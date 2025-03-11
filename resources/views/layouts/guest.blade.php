<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'UML') }}</title>

        <!-- FontAwesome JS-->
        <script defer src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>

        <!-- App CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    </head>
    <body class="app app-login p-0">
        <div class="app-auth-wrapper d-flex justify-content-center align-items-center min-vh-100">
            <div class="auth-main-col text-center p-5">
                <div class="d-flex flex-column align-items-center">
                    <div class="app-auth-body mx-auto">
                        <div class="app-auth-branding mb-4">
                            <a class="app-logo" href="{{ url('/') }}">
                                <img class="logo-icon me-2" src="{{ asset('assets/images/logoESP.png') }}" alt="logo" style="height: 60px;">
                            </a>
                        </div>
                        {{ $slot }}
                    </div>
                    <footer class="app-auth-footer">
                        <div class="container text-center py-3">
                            <small class="copyright">&copy; {{ date('Y') }} ESP. Tous droits réservés.</small>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
