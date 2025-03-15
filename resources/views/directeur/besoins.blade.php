<x-app-layout>
    <div class="app-card app-card-account shadow-sm d-flex flex-column">
        <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h4 class="app-card-title">Mes besoins budgétaires</h4>
                </div>
                <div class="col-auto">
                    <a href="{{ route('directeur.create-besoin') }}" class="btn app-btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouveau besoin
                    </a>
                </div>
            </div>
        </div>

        <div class="app-card-body px-4 w-100">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Description</th>
                            <th class="cell">Montant (FCFA)</th>
                            <th class="cell">Priorité</th>
                            <th class="cell">Statut</th>
                            <th class="cell">Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($besoins as $besoin)
                            <tr>
                                <td class="cell">{{ $besoin->description }}</td>
                                <td class="cell">{{ number_format($besoin->montant, 0, ',', ' ') }}</td>
                                <td class="cell">
                                    @if($besoin->priorite === 'high')
                                        <span class="badge bg-danger">Haute</span>
                                    @elseif($besoin->priorite === 'medium')
                                        <span class="badge bg-warning">Moyenne</span>
                                    @else
                                        <span class="badge bg-success">Basse</span>
                                    @endif
                                </td>
                                <td class="cell">
                                    @if($besoin->status === 'pending')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($besoin->status === 'approved')
                                        <span class="badge bg-success">Approuvé</span>
                                    @else
                                        <span class="badge bg-danger">Rejeté</span>
                                    @endif
                                </td>
                                <td class="cell">{{ $besoin->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">
                                    <div class="alert alert-info mb-0">
                                        Aucun besoin budgétaire enregistré pour le moment.
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
</x-app-layout>
