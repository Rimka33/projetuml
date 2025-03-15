<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- FontAwesome JS-->
        <script defer src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    </head>
    <body class="app">
        <header class="app-header fixed-top">
            <div class="app-header-inner py-2">
                <div class="container-fluid">
                    <div class="app-header-content">
                        <div class="row justify-content-between align-items-center g-0">
                            <div class="col-auto">
                                <a class="navbar-brand p-0" href="{{ route('home') }}">
                                    <img src="{{ asset('assets/images/logoESP.png') }}" alt="Logo ESP" class="app-logo">
                                </a>
                            </div>
                            <div class="app-utilities col-auto">
                                @auth
                                    <div class="app-utility-item">
                                        <a href="{{ route('profile.edit') }}" title="Paramètres" class="p-2">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                                                <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
                                            </svg>
                                        </a>
                                    </div>

                                    <div class="app-utility-item app-user-dropdown dropdown">
                                        <a class="dropdown-toggle p-2" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                            <img src="{{ Auth::user()->profile_image ? Storage::url(Auth::user()->profile_image) : asset('assets/images/user.png') }}" alt="user profile" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</span>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mon profil</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        Déconnexion
                                                    </a>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="app-wrapper">
            <div class="app-content pt-3 p-md-3 p-lg-4">
                <div class="container-xl">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Javascript -->
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
