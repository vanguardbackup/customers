@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Profile') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm New Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="billing_address" class="col-md-4 col-form-label text-md-end">{{ __('Billing Address') }}</label>
                                <div class="col-md-6">
                                    <input id="billing_address" type="text" class="form-control @error('billing_address') is-invalid @enderror" name="billing_address" value="{{ old('billing_address', $user->billing_address) }}" required autocomplete="billing_address">
                                    @error('billing_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="billing_city" class="col-md-4 col-form-label text-md-end">{{ __('City') }}</label>
                                <div class="col-md-6">
                                    <input id="billing_city" type="text" class="form-control @error('billing_city') is-invalid @enderror" name="billing_city" value="{{ old('billing_city', $user->billing_city) }}" required autocomplete="billing_city">
                                    @error('billing_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="billing_state" class="col-md-4 col-form-label text-md-end">{{ __('State') }}</label>
                                <div class="col-md-6">
                                    <input id="billing_state" type="text" class="form-control @error('billing_state') is-invalid @enderror" name="billing_state" value="{{ old('billing_state', $user->billing_state) }}" required autocomplete="billing_state">
                                    @error('billing_state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="billing_country" class="col-md-4 col-form-label text-md-end">{{ __('Country') }}</label>
                                <div class="col-md-6">
                                    <input id="billing_country" type="text" class="form-control @error('billing_country') is-invalid @enderror" name="billing_country" value="{{ old('billing_country', $user->billing_country) }}" required autocomplete="billing_country">
                                    @error('billing_country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="billing_zip_code" class="col-md-4 col-form-label text-md-end">{{ __('Zip Code') }}</label>
                                <div class="col-md-6">
                                    <input id="billing_zip_code" type="text" class="form-control @error('billing_zip_code') is-invalid @enderror" name="billing_zip_code" value="{{ old('billing_zip_code', $user->billing_zip_code) }}" required autocomplete="billing_zip_code">
                                    @error('billing_zip_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-vanguard">
                                        {{ __('Update Profile') }}
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
