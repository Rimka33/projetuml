<x-app-layout>
    <div class="container-xl">
        <div class="app-card app-card-account shadow-sm d-flex flex-column">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Tableau de bord - Directeur</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('directeur.create-besoin') }}" class="btn app-btn-primary">
                            <i class="fas fa-plus me-2"></i>Nouveau besoin
                        </a>
                    </div>
                </div>
            </div>

            <div class="app-card-body p-4">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table app-table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="min-width: 150px;">Type</th>
                                <th style="min-width: 200px;">Désignation</th>
                                <th style="min-width: 100px;">Quantité</th>
                                <th style="min-width: 120px;">Coût Unitaire</th>
                                <th style="min-width: 120px;">Coût Total</th>
                                <th style="min-width: 150px;">Description</th>
                                <th style="min-width: 100px;">Période</th>
                                <th style="min-width: 150px;">Source Financement</th>
                                <th style="min-width: 100px;">Priorité</th>
                                <th style="min-width: 100px;">Statut</th>
                                <th style="min-width: 150px;">Date de création</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($besoins as $besoin)
                                <tr>
                                    <td class="align-middle">{{ ucfirst(str_replace('_', ' ', $besoin->type)) }}</td>
                                    <td class="align-middle">{{ $besoin->designation }}</td>
                                    <td class="align-middle">{{ $besoin->quantite }}</td>
                                    <td class="align-middle">{{ number_format($besoin->cout_unitaire, 0, ',', ' ') }}</td>
                                    <td class="align-middle">{{ number_format($besoin->cout_total, 0, ',', ' ') }}</td>
                                    <td class="align-middle">{{ $besoin->motif }}</td>
                                    <td class="align-middle">{{ $besoin->periode }}</td>
                                    <td class="align-middle">{{ $besoin->source_financement }}</td>
                                    <td class="align-middle">
                                        @if($besoin->priorite === 'high')
                                            <span class="badge bg-danger">Haute</span>
                                        @elseif($besoin->priorite === 'medium')
                                            <span class="badge bg-warning">Moyenne</span>
                                        @else
                                            <span class="badge bg-success">Basse</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($besoin->status === 'pending')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($besoin->status === 'approved')
                                            <span class="badge bg-success">Approuvé</span>
                                        @else
                                            <span class="badge bg-danger">Rejeté</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $besoin->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-3">
                                        <div class="alert alert-info mb-0">
                                            Aucun besoin budgétaire enregistré pour le moment.
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
