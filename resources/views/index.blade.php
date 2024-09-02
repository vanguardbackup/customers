<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <meta
        name="description"
        content="Purchase support for Vanguard."
    />

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="container">
    <header class="text-center my-5">
        <h1 class="display-4">Vanguard Paid Support</h1>
        <p class="lead">Expert assistance from the creators of Vanguard.</p>
    </header>

    <main>
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Get Support</h2>
                        <p class="card-text">Need help with Vanguard? Get direct support from the creators themselves.</p>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item">One-on-one assistance</li>
                            <li class="list-group-item">Quick problem resolution</li>
                            <li class="list-group-item">Expert advice on best practices</li>
                        </ul>
                        <p class="h4">Price: £30 per hour</p>
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-vanguard me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">How It Works</h2>
                        <ol class="list-group list-group-numbered mt-3">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Create an account</div>
                                    Sign up on our support platform
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Purchase support hours</div>
                                    Choose the amount of support time you need
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Receive confirmation</div>
                                    Get an email with further instructions
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Schedule your session</div>
                                    Our team will contact you to arrange a time
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Get expert help</div>
                                    Connect with our experts and solve your issues
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center text-muted mb-5">
        <nav class="mb-3">
            <a href="https://vanguardbackup.com" class="text-decoration-none me-3">Vanguard Home</a>
            <a href="https://docs.vanguardbackup.com" class="text-decoration-none me-3">Documentation</a>
            <a href="https://github.com/vanguardbackup/vanguard" class="text-decoration-none">GitHub</a>
        </nav>
        <p>&copy; {{ date('Y') }} Vanguard. All rights reserved.</p>
    </footer>
</div>
</body>
</html>
