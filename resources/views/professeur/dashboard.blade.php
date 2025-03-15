<x-app-layout>
    <div class="container-xl">
        <div class="app-card app-card-account shadow-sm d-flex flex-column">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Tableau de bord du Professeur</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('professeur.create-besoin') }}" class="btn app-btn-primary">
                            <i class="fas fa-plus"></i> Nouveau besoin
                        </a>
                    </div>
                </div>
            </div>

            <div class="app-card-body px-4 w-100">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Désignation</th>
                                <th>Quantité</th>
                                <th>Coût Unitaire</th>
                                <th>Coût Total</th>
                                <th>Description</th>
                                <th>Période</th>
                                <th>Source Financement</th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Date de création</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($besoins as $besoin)
                                <tr>
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
                                    <td>{{ $besoin->quantite }}</td>
                                    <td>{{ number_format($besoin->cout_unitaire, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ number_format($besoin->cout_total, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ $besoin->motif }}</td>
                                    <td>{{ $besoin->periode }}</td>
                                    <td>{{ $besoin->source_financement }}</td>
                                    <td>
                                        @switch($besoin->priorite)
                                            @case('high')
                                                <span class="badge bg-danger">Haute</span>
                                                @break
                                            @case('medium')
                                                <span class="badge bg-warning">Moyenne</span>
                                                @break
                                            @default
                                                <span class="badge bg-info">Basse</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($besoin->status)
                                            @case('pending')
                                                <span class="badge bg-warning">En attente</span>
                                                @break
                                            @case('validated_by_chef')
                                                <span class="badge bg-info">Validé par le chef de département</span>
                                                @break
                                            @case('rejected_by_chef')
                                                <span class="badge bg-danger">Rejeté par le chef de département</span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-success">Approuvé par le responsable financier</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">Rejeté par le responsable financier</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Statut inconnu</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $besoin->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">Aucun besoin budgétaire enregistré</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
