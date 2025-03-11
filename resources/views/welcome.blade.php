<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bienvenue - UML</title>

        <!-- FontAwesome JS-->
        <script defer src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>

        <!-- App CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

        <!-- Styles -->
        <style>
            .welcome-header {
                background: var(--primary-color);
                padding: 2rem 0;
                color: white;
            }
            .welcome-content {
                padding: 4rem 0;
            }
            .feature-card {
                background: white;
                border-radius: 8px;
                padding: 2rem;
                margin-bottom: 2rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                transition: transform 0.3s ease;
            }
            .feature-card:hover {
                transform: translateY(-5px);
            }
            .feature-icon {
                background: var(--accent-color);
                color: var(--primary-color);
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
            }
            .auth-buttons .btn {
                margin: 0 0.5rem;
            }
        </style>
    </head>
    <body>
        <header class="welcome-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <img src="{{ asset('assets/images/logoESP.png') }}" alt="Logo ESP" class="img-fluid mb-3" style="max-height: 80px;">
                        <h1>Bienvenue sur UML</h1>
                        <p class="lead">Plateforme de gestion des départements de l'ESP</p>
                    </div>
                    <div class="col-md-6 text-end">
                        @if (Route::has('login'))
                            <div class="auth-buttons">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn app-btn-primary">Tableau de bord</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn app-btn-primary">Connexion</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-light">Inscription</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main class="welcome-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <h3>Gestion des Utilisateurs</h3>
                            <p>Gérez facilement les directeurs et chefs de département</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-building fa-2x"></i>
                            </div>
                            <h3>Gestion des Départements</h3>
                            <p>Organisez et suivez les différents départements de l'ESP</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                            <h3>Tableau de Bord</h3>
                            <p>Visualisez toutes les informations importantes en un coup d'œil</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="app-footer">
            <div class="container text-center">
                <p>&copy; {{ date('Y') }} ESP - Tous droits réservés</p>
            </div>
        </footer>

        <!-- Javascript -->
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
