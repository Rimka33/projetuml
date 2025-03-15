<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Gestion des Besoins Budgétaires' }}</title>

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">

    <!-- Styles -->
    <style>
        .app-card-stat .stats-type {
            font-size: 0.875rem;
            color: #828282;
            text-transform: uppercase;
        }
        .app-card-stat .stats-figure {
            font-size: 1.8rem;
            color: #252930;
        }
        .app-card {
            position: relative;
            background: #fff;
            border-radius: 0.25rem;
        }
        .app-card.border-left-decoration {
            border-left: 3px solid var(--primary-color);
        }
        .app-card .app-card-link-mask {
            position: absolute;
            width: 100%;
            height: 100%;
            display: block;
            left: 0;
            top: 0;
        }
        .app-card .app-card-header {
            border-bottom: 1px solid #e7e9ed;
        }
        .app-card .app-card-title {
            font-size: 1.125rem;
            margin-bottom: 0;
        }
        .app-card .card-header-action {
            font-size: 0.875rem;
        }
        .app-card .card-header-action a:hover {
            text-decoration: none;
        }
        .app-card .form-select-holder {
            display: inline-block;
        }
        .app-card .btn-close {
            padding: 1rem;
        }
        .app-card .btn-close:focus {
            box-shadow: none;
        }
        .app-card.app-card-orders-table .table {
            font-size: 0.875rem;
        }
        .app-card.app-card-orders-table .table .cell {
            border-color: #e7e9ed;
            color: #5d6778;
            vertical-align: middle;
        }
        .app-card .app-icon-holder {
            display: inline-block;
            background: #edfbf9;
            color: var(--primary-color);
            width: 50px;
            height: 50px;
            padding-top: 10px;
            font-size: 1rem;
            text-align: center;
            border-radius: 50%;
        }
        .app-card .app-card-body.has-card-actions {
            position: relative;
            padding-right: 1rem !important;
        }
        .app-card .app-card-body .app-card-actions {
            display: inline-block;
            width: 30px;
            height: 30px;
            text-align: center;
            border-radius: 50%;
            position: absolute;
            z-index: 10;
            right: 0.75rem;
            top: 0.75rem;
        }
        .app-card .app-card-body .app-card-actions:hover {
            background: #f5f6fe;
        }
        .app-card .app-card-body .app-card-actions .dropdown-menu {
            font-size: 0.8125rem;
        }
        .app-card .app-card-doc:hover {
            transform: translateY(-0.25rem);
        }
        .app-card .app-card-thumb-holder {
            position: relative;
            background: #e9ecef;
            text-align: center;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .app-card .app-card-thumb-holder .app-card-thumb {
            max-width: 150px;
        }
        .app-card .app-card-thumb-holder .badge {
            position: absolute;
            right: 0.75rem;
            top: 0.75rem;
        }
        .app-card .app-card-progress-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .app-card .app-card-stats-table {
            margin-bottom: 0;
        }
        .app-card .app-card-stats-table .table {
            font-size: 0.875rem;
        }
        .app-card .app-card-stats-table .meta {
            color: #828282;
            font-weight: 500;
            font-size: 0.875rem;
        }
        .app-card .app-card-stats-table .stat-cell {
            text-align: right;
        }
        .app-card .app-table-hover > tbody > tr:hover {
            background-color: #fafbff;
        }
    </style>
</head>
<body class="app">
    <header class="app-header fixed-top">
        <div class="app-header-inner">
            <div class="container-fluid py-2">
                <div class="app-header-content">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="app-utilities col-auto">
                            <div class="app-utility-item app-user-dropdown dropdown">
                                <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                    <img src="{{ asset('assets/images/user.png') }}" alt="user profile" class="rounded-circle" width="32" height="32">
                                    {{ Auth::user()->nom }} {{ Auth::user()->prenom }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user fa-fw me-2"></i>
                                            Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="fas fa-sign-out-alt fa-fw me-2"></i>
                                                Déconnexion
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="app-sidepanel" class="app-sidepanel">
            <div id="sidepanel-drop" class="sidepanel-drop"></div>
            <div class="sidepanel-inner d-flex flex-column">
                <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
                <div class="app-branding">
                    <a class="app-logo" href="{{ route('dashboard') }}">
                        <img class="logo-icon me-2" src="{{ asset('assets/images/esp-logo.png') }}" alt="logo">
                        <span class="logo-text">ESP Budget</span>
                    </a>
                </div>

                <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                        @if(Auth::user()->role === 'professeur')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('professeur.dashboard') ? 'active' : '' }}" href="{{ route('professeur.dashboard') }}">
                                <span class="nav-icon">
                                    <i class="fas fa-home"></i>
                                </span>
                                <span class="nav-link-text">Tableau de bord</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('professeur.create-besoin') }}">
                                <span class="nav-icon">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="nav-link-text">Nouveau Besoin</span>
                            </a>
                        </li>
                        @endif

                        @if(Auth::user()->role === 'chef_departement')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('chef-departement.dashboard') ? 'active' : '' }}" href="{{ route('chef-departement.dashboard') }}">
                                <span class="nav-icon">
                                    <i class="fas fa-home"></i>
                                </span>
                                <span class="nav-link-text">Tableau de bord</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('chef-departement.professeurs.index') }}">
                                <span class="nav-icon">
                                    <i class="fas fa-users"></i>
                                </span>
                                <span class="nav-link-text">Professeurs</span>
                            </a>
                        </li>
                        @endif

                        @if(Auth::user()->role === 'responsable_financier')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('responsable-financier.dashboard') ? 'active' : '' }}" href="{{ route('responsable-financier.dashboard') }}">
                                <span class="nav-icon">
                                    <i class="fas fa-home"></i>
                                </span>
                                <span class="nav-link-text">Tableau de bord</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('responsable-financier.create-besoin') }}">
                                <span class="nav-icon">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="nav-link-text">Nouveau Besoin</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

        <footer class="app-footer">
            <div class="container text-center py-3">
                <p>&copy; {{ date('Y') }} ESP - Tous droits réservés</p>
            </div>
        </footer>
    </div>

    <!-- Javascript -->
    <script src="{{ asset('assets/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
