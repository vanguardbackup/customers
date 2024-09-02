@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <p>Your current support time balance: {{ $user->support_time_balance }} hours</p>
                        <a href="{{ route('support.purchase') }}" class="btn btn-primary">Purchase Support Time</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
