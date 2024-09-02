<?php

namespace App\Http\Controllers;

use App\Mail\InformCustomer;
use App\Mail\InformDevsMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Laravel\Facades\Mollie;

class SupportTimeController extends Controller
{
    private int $unitPrice = 30; // Price per hour of support time in GBP

    public function showPurchaseForm()
    {
        return view('support.purchase', ['unitPrice' => $this->unitPrice]);
    }

    public function initiatePurchase(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();
        $quantity = $request->input('quantity');
        $totalAmount = $quantity * $this->unitPrice;

        if (!$this->userHasCompleteBillingDetails($user)) {
            return redirect()->route('billing.edit')->with('error', 'Please complete your billing details before making a purchase.');
        }

        try {
            $payment = Mollie::api()->payments->create([
                "amount" => [
                    "currency" => "GBP",
                    "value" => number_format($totalAmount, 2, '.', '')
                ],
                "description" => "Purchase of {$quantity} hour(s) of support time",
                "redirectUrl" => route('support.payment.callback'),
                "webhookUrl" => route('webhooks.mollie'),
                "metadata" => [
                    "user_id" => $user->id,
                    "quantity" => $quantity,
                    "billing_address" => $user->billing_address,
                    "billing_city" => $user->billing_city,
                    "billing_state" => $user->billing_state,
                    "billing_country" => $user->billing_country,
                    "billing_zip_code" => $user->billing_zip_code,
                ],
            ]);

            return redirect($payment->getCheckoutUrl(), 303);
        } catch (ApiException $e) {
            Log::error('Mollie API error during payment initiation', ['error' => $e->getMessage()]);
            return redirect()->route('home')->with('error', 'An error occurred while initiating your payment. Please try again or contact support.');
        }
    }

    public function handlePaymentCallback(Request $request): RedirectResponse
    {
        return redirect()->route('home')->with('info', 'Your payment is being processed. We\'ll update your account once it\'s completed.');
    }

    public function handleWebhookNotification(Request $request)
    {
        try {
            $paymentId = $request->input('id');
            $payment = Mollie::api()->payments->get($paymentId);

            if ($payment->isPaid()) {
                $metadata = $payment->metadata;
                $user = User::findOrFail($metadata->user_id);
                $quantity = $metadata->quantity;

                // Update user's support time balance
                $user->support_time_balance += $quantity;
                $user->save();

                Log::info("Support time purchase successful", ['user_id' => $user->id, 'quantity' => $quantity]);

                // send emails letting team + customer know!
                Mail::to('support@vanguardbackup.com')->send(new InformDevsMail($user));
                Mail::to($user->email)->send(new InformCustomer($user));

                return response('OK', 200);
            }

            if ($payment->isCanceled() || $payment->isExpired() || $payment->isFailed()) {
                Log::info("Payment not completed", ['status' => $payment->status, 'payment_id' => $paymentId]);
            }

            return response('OK', 200);

        } catch (ApiException $e) {
            Log::error('Mollie API error in webhook', ['error' => $e->getMessage(), 'paymentId' => $request->input('id')]);
            return response('Error', 500);
        }
    }

    private function userHasCompleteBillingDetails(User $user): bool
    {
        return !empty($user->billing_address) &&
            !empty($user->billing_city) &&
            !empty($user->billing_state) &&
            !empty($user->billing_country) &&
            !empty($user->billing_zip_code);
    }
}
