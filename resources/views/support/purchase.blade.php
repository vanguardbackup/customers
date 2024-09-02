@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Purchase Support Time</div>

                    <div class="card-body">
                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading">Important Information</h5>
                            <p class="mb-0">You are about to purchase support time. Please note:</p>
                            <ul class="mb-0">
                                <li>Support time is billed in whole hours.</li>
                                <li>The minimum purchase is 1 hour.</li>
                                <li><strong>This purchase is non-refundable.</strong> Please ensure you need the support time before proceeding.</li>
                            </ul>
                        </div>

                        <form method="POST" action="{{ route('support.purchase.initiate') }}">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="quantity" class="col-md-4 col-form-label text-md-right">Quantity (hours)</label>
                                <div class="col-md-6">
                                    <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', 1) }}" required autofocus min="1">
                                    @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-4 col-form-label text-md-right">Price per hour</label>
                                <div class="col-md-6">
                                    <p class="form-control-plaintext">£{{ number_format($unitPrice, 2) }}</p>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-md-4 col-form-label text-md-right">Total Price</label>
                                <div class="col-md-6">
                                    <p class="form-control-plaintext font-weight-bold" id="totalPrice">£{{ number_format($unitPrice, 2) }}</p>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Purchase Support Time
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const totalPriceElement = document.getElementById('totalPrice');
            const unitPrice = {{ $unitPrice }};

            function updateTotalPrice() {
                const quantity = parseInt(quantityInput.value);
                const totalPrice = quantity * unitPrice;
                totalPriceElement.textContent = '£' + totalPrice.toFixed(2);
            }

            quantityInput.addEventListener('input', updateTotalPrice);
        });
    </script>
@endsection
