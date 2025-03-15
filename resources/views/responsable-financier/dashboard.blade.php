<x-app-layout>
    <div class="container-xl">
        <!-- Résumé des besoins -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Total des Besoins</h4>
                        <div class="stats-figure">{{ $totalBesoins }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">En Attente</h4>
                        <div class="stats-figure">{{ $besoinsEnAttente }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Approuvés</h4>
                        <div class="stats-figure text-success">{{ $besoinsApprouves }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Montant Total</h4>
                        <div class="stats-figure">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des professeurs -->
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Professeurs du Département</h4>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">
                                        <div class="alert alert-info mb-0">
                                            Aucun professeur dans le département.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Liste des besoins du responsable financier -->
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Mes Besoins Budgétaires</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Désignation</th>
                                <th>Montant</th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mesBesoins as $besoin)
                                <tr>
                                    <td>{{ $besoin->created_at->format('d/m/Y') }}</td>
                                    <td>
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
                                    <td>{{ $besoin->designation }}</td>
                                    <td>{{ number_format($besoin->cout_total, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="badge bg-{{ $besoin->priorite === 'high' ? 'danger' : ($besoin->priorite === 'medium' ? 'warning' : 'success') }}">
                                            {{ $besoin->priorite === 'high' ? 'Haute' : ($besoin->priorite === 'medium' ? 'Moyenne' : 'Basse') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $besoin->status_color }}">
                                            {{ $besoin->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('responsable-financier.show-besoin', $besoin->id) }}" class="btn btn-sm app-btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">
                                        <div class="alert alert-info mb-0">
                                            Vous n'avez pas encore ajouté de besoins budgétaires.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Liste des besoins -->
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Liste des Besoins du Département</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('responsable-financier.create-besoin') }}" class="btn app-btn-primary">
                            <i class="fas fa-plus me-2"></i>Nouveau Besoin
                        </a>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Demandeur</th>
                                <th>Type</th>
                                <th>Désignation</th>
                                <th>Montant</th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($besoins as $besoin)
                                <tr>
                                    <td>{{ $besoin->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $besoin->utilisateur->nom }} {{ $besoin->utilisateur->prenom }}</td>
                                    <td>
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
                                    <td>{{ $besoin->designation }}</td>
                                    <td>{{ number_format($besoin->cout_total, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="badge bg-{{ $besoin->priorite === 'high' ? 'danger' : ($besoin->priorite === 'medium' ? 'warning' : 'success') }}">
                                            {{ $besoin->priorite === 'high' ? 'Haute' : ($besoin->priorite === 'medium' ? 'Moyenne' : 'Basse') }}
                                        </span>
                                    </td>
                                    <td>
                                        @switch($besoin->status)
                                            @case('pending')
                                                <span class="badge bg-warning">En attente</span>
                                                @break
                                            @case('validated_by_chef')
                                                <span class="badge bg-info">Validé par le chef</span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-success">Approuvé</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">Rejeté</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $besoin->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('responsable-financier.show-besoin', $besoin->id) }}" class="btn btn-sm app-btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($besoin->status === 'validated_by_chef')
                                                <a href="{{ route('responsable-financier.edit-besoin', $besoin->id) }}" class="btn btn-sm app-btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-3">
                                        <div class="alert alert-info mb-0">
                                            Aucun besoin enregistré pour le moment.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($besoins->hasPages())
                    <div class="mt-4">
                        {{ $besoins->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
