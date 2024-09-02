<?php

use App\Http\Controllers\SupportTimeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/support/purchase', [SupportTimeController::class, 'showPurchaseForm'])->name('support.purchase');
Route::post('/support/purchase', [SupportTimeController::class, 'initiatePurchase'])->name('support.purchase.initiate');
Route::get('/support/payment/callback', [SupportTimeController::class, 'handlePaymentCallback'])->name('support.payment.callback');
Route::post('webhooks/mollie', [SupportTimeController::class, 'handleWebhookNotification'])->name('webhooks.mollie');
