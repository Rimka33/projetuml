<x-app-layout>
    <div class="container-xl">
        <!-- Messages de session -->
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

        <h1 class="app-page-title">Tableau de bord</h1>

        <!-- Section des statistiques -->
        <div class="row g-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Total des Besoins</h4>
                        <div class="stats-figure">{{ $totalBesoins }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">En Attente</h4>
                        <div class="stats-figure">{{ $besoinsEnAttente }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Validés</h4>
                        <div class="stats-figure text-success">{{ $nombreBesoinsValides }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Rejetés</h4>
                        <div class="stats-figure text-danger">{{ $besoinsRejetes }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section des besoins du chef de département -->
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Demandes à Valider</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th class="cell">Date</th>
                                <th class="cell">Demandeur</th>
                                <th class="cell">Type</th>
                                <th class="cell">Désignation</th>
                                <th class="cell">Coût Total</th>
                                <th class="cell">Période</th>
                                <th class="cell">Statut</th>
                                <th class="cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($besoinsAValider as $besoin)
                                <tr>
                                    <td class="cell">{{ $besoin->created_at->format('d/m/Y') }}</td>
                                    <td class="cell">{{ $besoin->utilisateur->nom }} {{ $besoin->utilisateur->prenom }}</td>
                                    <td class="cell">
                                        @switch($besoin->type)
                                            @case('materiel_cours')
                                                Matériel de cours
                                                @break
                                            @case('materiel_imprimerie')
                                                Matériel d'imprimerie
                                                @break
                                            @case('projet_travaux')
                                                Projet de travaux
                                                @break
                                            @case('materiel_roulant')
                                                Matériel roulant
                                                @break
                                            @default
                                                {{ ucfirst($besoin->type) }}
                                        @endswitch
                                    </td>
                                    <td class="cell">{{ $besoin->designation }}</td>
                                    <td class="cell">{{ number_format($besoin->cout_total, 0, ',', ' ') }} FCFA</td>
                                    <td class="cell">{{ $besoin->periode }}</td>
                                    <td class="cell">
                                        <span class="badge bg-{{ $besoin->status_color }}">
                                            {{ $besoin->status_label }}
                                        </span>
                                    </td>
                                    <td class="cell">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('chef-departement.show-besoin', $besoin->id) }}" class="btn btn-sm app-btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($besoin->status === 'approved_by_rf')
                                                <form action="{{ route('chef-departement.validate-besoin', $besoin->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm app-btn-success ms-1" onclick="return confirm('Êtes-vous sûr de vouloir valider ce besoin ?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm app-btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $besoin->id }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucune demande à valider pour le moment</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $besoinsAValider->links() }}

        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Mes Demandes</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('chef-departement.create-besoin') }}" class="btn app-btn-primary">
                            <i class="fas fa-plus me-2"></i>Nouvelle Demande
                        </a>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th class="cell">Date</th>
                                <th class="cell">Type</th>
                                <th class="cell">Désignation</th>
                                <th class="cell">Coût Total</th>
                                <th class="cell">Période</th>
                                <th class="cell">Statut</th>
                                <th class="cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mesBesoins as $besoin)
                                <tr>
                                    <td class="cell">{{ $besoin->created_at->format('d/m/Y') }}</td>
                                    <td class="cell">
                                        @switch($besoin->type)
                                            @case('materiel_cours')
                                                Matériel de cours
                                                @break
                                            @case('materiel_imprimerie')
                                                Matériel d'imprimerie
                                                @break
                                            @case('projet_travaux')
                                                Projet de travaux
                                                @break
                                            @case('materiel_roulant')
                                                Matériel roulant
                                                @break
                                            @default
                                                {{ ucfirst($besoin->type) }}
                                        @endswitch
                                    </td>
                                    <td class="cell">{{ $besoin->designation }}</td>
                                    <td class="cell">{{ number_format($besoin->cout_total, 0, ',', ' ') }} FCFA</td>
                                    <td class="cell">{{ $besoin->periode }}</td>
                                    <td class="cell">
                                        <span class="badge bg-{{ $besoin->status_color }}">
                                            {{ $besoin->status_label }}
                                        </span>
                                    </td>
                                    <td class="cell">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('chef-departement.show-besoin', $besoin->id) }}" class="btn btn-sm app-btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($besoin->status === 'pending')
                                                <a href="{{ route('chef-departement.edit-besoin', $besoin->id) }}" class="btn btn-sm app-btn-secondary ms-1">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('chef-departement.delete-besoin', $besoin->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm app-btn-danger ms-1" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce besoin ?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Vous n'avez pas encore créé de demande</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $mesBesoins->links() }}

        <!-- Section des demandes validées définitivement -->
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Demandes Validées Définitivement</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th class="cell">Date</th>
                                <th class="cell">Demandeur</th>
                                <th class="cell">Type</th>
                                <th class="cell">Désignation</th>
                                <th class="cell">Coût Total</th>
                                <th class="cell">Période</th>
                                <th class="cell">Statut</th>
                                <th class="cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($besoinsValides as $besoin)
                                <tr>
                                    <td class="cell">{{ $besoin->created_at->format('d/m/Y') }}</td>
                                    <td class="cell">{{ $besoin->utilisateur->nom }} {{ $besoin->utilisateur->prenom }}</td>
                                    <td class="cell">
                                        @switch($besoin->type)
                                            @case('materiel_cours')
                                                Matériel de cours
                                                @break
                                            @case('materiel_imprimerie')
                                                Matériel d'imprimerie
                                                @break
                                            @case('projet_travaux')
                                                Projet de travaux
                                                @break
                                            @case('materiel_roulant')
                                                Matériel roulant
                                                @break
                                            @default
                                                {{ ucfirst($besoin->type) }}
                                        @endswitch
                                    </td>
                                    <td class="cell">{{ $besoin->designation }}</td>
                                    <td class="cell">{{ number_format($besoin->cout_total, 0, ',', ' ') }} FCFA</td>
                                    <td class="cell">{{ $besoin->periode }}</td>
                                    <td class="cell">
                                        <span class="badge bg-{{ $besoin->status_color }}">
                                            {{ $besoin->status_label }}
                                        </span>
                                    </td>
                                    <td class="cell">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('chef-departement.show-besoin', $besoin->id) }}" class="btn btn-sm app-btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucune demande validée définitivement pour le moment</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $besoinsValides->links() }}

        <!-- Section des professeurs -->
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Professeurs du Département</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('chef-departement.create-professeur') }}" class="btn app-btn-primary">
                            <i class="fas fa-plus me-2"></i>Ajouter un professeur
                        </a>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Spécialité</th>
                                <th>Grade</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($professeurs as $professeur)
                                <tr>
                                    <td>{{ $professeur->utilisateur->nom }}</td>
                                    <td>{{ $professeur->utilisateur->prenom }}</td>
                                    <td>{{ $professeur->utilisateur->email }}</td>
                                    <td>{{ $professeur->specialite }}</td>
                                    <td>{{ $professeur->grade }}</td>
                                    <td>
                                        <span class="badge bg-{{ $professeur->status === 'actif' ? 'success' : 'danger' }}">
                                            {{ ucfirst($professeur->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3">
                                        <div class="alert alert-info mb-0">
                                            Aucun professeur enregistré pour le moment.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
