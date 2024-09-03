<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Mail\InformCustomerMail;
use App\Mail\InformTeamMail;
use App\Models\User;
use App\Models\SupportTimePurchase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Laravel\Facades\Mollie;

/**
 * Handles Mollie webhook notifications for support time purchases.
 */
class MollieWebhookController extends Controller
{
    /**
     * Handle the webhook notification from Mollie.
     */
    public function handleWebhookNotification(Request $request): Response
    {
        try {
            $payment = Mollie::api()->payments->get($request->input('id'));

            if ($payment->isPaid()) {
                $this->processPaidPayment($payment);
            } elseif ($this->isPaymentFailed($payment)) {
                $this->logFailedPayment($payment);
            }

            return response('OK', 200);
        } catch (ApiException $e) {
            Log::error('Mollie API error in webhook', [
                'error' => $e->getMessage(),
                'paymentId' => $request->input('id'),
            ]);

            return response('Error', 500);
        }
    }

    /**
     * Process a successful payment.
     */
    private function processPaidPayment(\Mollie\Api\Resources\Payment $payment): void
    {
        $metadata = $payment->metadata;
        $user = User::findOrFail($metadata->user_id);

        DB::transaction(function () use ($user, $metadata, $payment) {
            $existingPurchase = SupportTimePurchase::where('payment_id', $payment->id)->first();

            if ($existingPurchase) {
                Log::info('Duplicate payment webhook received', [
                    'payment_id' => $payment->id,
                    'user_id' => $user->id,
                ]);
                return;
            }

            $latestPurchase = $user->supportTimePurchases()
                ->whereNull('expired_at')
                ->where('support_type', $metadata->support_type)
                ->where('created_at', '>', now()->subMinutes(5))
                ->orderByDesc('created_at')
                ->first();

            if ($latestPurchase) {
                $latestPurchase->quantity += $metadata->quantity;
                $latestPurchase->amount += $payment->amount->value;
                $latestPurchase->save();

                Log::info('Support time purchase consolidated', [
                    'user_id' => $user->id,
                    'quantity' => $metadata->quantity,
                    'purchase_id' => $latestPurchase->id,
                ]);
            } else {
                $newPurchase = new SupportTimePurchase([
                    'user_id' => $user->id,
                    'quantity' => $metadata->quantity,
                    'support_type' => $metadata->support_type,
                    'details' => $metadata->details,
                    'payment_id' => $payment->id,
                    'amount' => $payment->amount->value,
                ]);
                $newPurchase->save();

                Log::info('New support time purchase created', [
                    'user_id' => $user->id,
                    'quantity' => $metadata->quantity,
                    'purchase_id' => $newPurchase->id,
                ]);
            }

            $this->sendNotificationEmails($user, $metadata, $payment->id);
        });
    }

    /**
     * Check if the payment has failed, been canceled, or expired.
     */
    private function isPaymentFailed(\Mollie\Api\Resources\Payment $payment): bool
    {
        return $payment->isCanceled() || $payment->isExpired() || $payment->isFailed();
    }

    /**
     * Log information about a failed payment.
     */
    private function logFailedPayment(\Mollie\Api\Resources\Payment $payment): void
    {
        Log::info('Payment not completed', [
            'status' => $payment->status,
            'payment_id' => $payment->id,
        ]);
    }

    /**
     * Send notification emails to the support team and the customer.
     */
    private function sendNotificationEmails(User $user, object $metadata, string $paymentId): void
    {
        Mail::to('support@vanguardbackup.com')->queue(new InformTeamMail(
            $user,
            $metadata->quantity,
            $metadata->support_type,
            $metadata->details,
            $paymentId
        ));

        Mail::to($user->email)->queue(new InformCustomerMail(
            $user,
            $metadata->quantity,
            $metadata->support_type,
            $metadata->details,
            $paymentId
        ));
    }
}
