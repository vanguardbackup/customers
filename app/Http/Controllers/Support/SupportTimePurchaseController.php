<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\SupportTimePurchase;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Payment;
use Mollie\Laravel\Facades\Mollie;

/**
 * Handles support time purchase and related operations.
 */
class SupportTimePurchaseController extends Controller
{
    private const UNIT_PRICE = 30; // Price per hour of support time in GBP

    /**
     * Display the support time purchase form.
     */
    public function showPurchaseForm(): View
    {
        return view('support.purchase', ['unitPrice' => self::UNIT_PRICE]);
    }

    /**
     * Initiate the purchase of support time.
     */
    public function initiatePurchase(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'support_type' => ['required', 'string', 'in:technical,install,other'],
            'details' => ['nullable', 'string', 'max:500'],
            'terms' => ['required', 'accepted'],
        ]);

        $user = auth()->user();

        try {
            DB::beginTransaction();

            $payment = $this->createMolliePayment($user, $validated);
            $this->createSupportTimePurchase($user, $validated, $payment);

            DB::commit();

            return redirect($payment->getCheckoutUrl(), 303);
        } catch (ApiException $e) {
            DB::rollBack();
            Log::error('Mollie API error during payment initiation', ['error' => $e->getMessage()]);

            return redirect()->route('home')
                ->with('error', 'An error occurred while initiating your payment. Please try again or contact support@vanguardbackup.com.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error during support time purchase', ['error' => $e->getMessage()]);

            return redirect()->route('home')
                ->with('error', 'An unexpected error occurred. Please try again or contact support@vanguardbackup.com.');
        }
    }

    /**
     * Handle the payment callback from Mollie.
     */
    public function handlePaymentCallback(): RedirectResponse
    {
        return redirect()->route('home')
            ->with('info', 'Your payment is being processed. We\'ll update your account once it\'s completed.');
    }

    /**
     * Create a Mollie payment for support time purchase.
     */
    private function createMolliePayment(User $user, array $validated): Payment
    {
        $totalAmount = $validated['quantity'] * self::UNIT_PRICE;

        return Mollie::api()->payments->create([
            'amount' => [
                'currency' => 'GBP',
                'value' => number_format($totalAmount, 2, '.', ''),
            ],
            'description' => "Purchase of {$validated['quantity']} hour(s) of {$validated['support_type']} support",
            'redirectUrl' => route('support.payment.callback'),
            'webhookUrl' => route('webhooks.mollie'),
            'metadata' => [
                'user_id' => $user->id,
                'quantity' => $validated['quantity'],
                'support_type' => $validated['support_type'],
                'details' => $validated['details'],
                'billing_address' => $user->billing_address,
                'billing_city' => $user->billing_city,
                'billing_state' => $user->billing_state,
                'billing_country' => $user->billing_country,
                'billing_zip_code' => $user->billing_zip_code,
            ],
        ]);
    }

    /**
     * Create a SupportTimePurchase record.
     */
    private function createSupportTimePurchase(User $user, array $validated, Payment $payment): void
    {
        SupportTimePurchase::create([
            'user_id' => $user->id,
            'quantity' => $validated['quantity'],
            'support_type' => $validated['support_type'],
            'details' => $validated['details'],
            'payment_id' => $payment->id,
            'amount' => $payment->amount->value,
        ]);
    }
}
