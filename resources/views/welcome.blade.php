<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bienvenue - UML</title>

        <!-- FontAwesome JS-->
        <script defer src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- App CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
    </head>
    <body>
        <header class="welcome-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <img src="{{ asset('assets/images/logoESP.png') }}" alt="Logo ESP" class="img-fluid mb-3" style="max-height: 80px;">
                        <h1>Bienvenue sur la plateforme de gestion des besoins</h1>
                    </div>
                    <div class="col-md-6 text-end">
                        @if (Route::has('login'))
                            <div class="auth-buttons">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn app-btn-primary">Tableau de bord</a>
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-light">Déconnexion</button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn app-btn-primary">Connexion</a>
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
                            <p>Gérez facilement la gestion des accès</p>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
