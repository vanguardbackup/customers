<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vanguard Paid Support - Expert Assistance for Your Backup Needs</title>
    <meta name="description" content="Get expert support for Vanguard directly from its creators. Fast, efficient, and tailored to your needs.">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:400,600,700" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .bg-black {
            background-color: #000;
        }
        .card {
            border: none;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ url('/') }}">
            <span class="brand-logo-large">Vanguard</span> <span class="brand-logo-small">| Paid Support Platform</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="https://vanguardbackup.com">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://docs.vanguardbackup.com">Documentation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/vanguardbackup/vanguard">GitHub</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="bg-black text-white py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-medium">Vanguard Paid Support</h1>
        <p class="lead">Expert assistance from the creators of Vanguard, tailored to your needs.</p>
        <a href="{{ route('register') }}" class="btn btn-vanguard-secondary btn-lg mt-3">Get Started</a>
    </div>
</header>

<main class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title fw-semibold mb-4">Premium Support</h2>
                        <p class="card-text">Get direct, personalized support from Vanguard's expert creators.</p>
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item"><i class="bi bi-check-circle-fill text-success me-2"></i>One-on-one assistance</li>
                            <li class="list-group-item"><i class="bi bi-check-circle-fill text-success me-2"></i>Quick problem resolution</li>
                            <li class="list-group-item"><i class="bi bi-check-circle-fill text-success me-2"></i>Expert advice on best practices</li>
                            <li class="list-group-item"><i class="bi bi-check-circle-fill text-success me-2"></i>Priority response times</li>
                        </ul>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="h3 fw-semibold mb-0">£30 per hour</p>
                            <a href="{{ route('login') }}" class="btn btn-vanguard">Get Support Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title fw-semibold mb-4">How It Works</h2>
                        <ol class="list-group list-group-numbered">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-semibold">Create an account</div>
                                    Quick and easy sign-up process
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-semibold">Purchase support hours</div>
                                    Flexible options to suit your needs
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-semibold">Schedule your session</div>
                                    Choose a time that works for you
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-semibold">Get expert help</div>
                                    Connect with our team and solve your issues
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<section class="bg-light py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Ready to get started?</h2>
        <p class="lead mb-4">Join the growing community of satisfied Vanguard users who trust our expert support.</p>
        <a href="{{ route('register') }}" class="btn btn-vanguard btn-lg me-2">Sign Up Now</a>
        <a href="{{ route('login') }}" class="btn btn-vanguard-outline btn-lg">Login</a>
    </div>
</section>

<footer class="bg-black text-white py-4">
    <div class="container text-center">
        <nav class="mb-3">
            <a href="https://vanguardbackup.com" class="text-white text-decoration-none me-3">Vanguard Home</a>
            <a href="https://docs.vanguardbackup.com" class="text-white text-decoration-none me-3">Documentation</a>
            <a href="https://github.com/vanguardbackup/vanguard" class="text-white text-decoration-none">GitHub</a>
        </nav>
        <p class="mb-0">&copy; {{ date('Y') }} Vanguard. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
