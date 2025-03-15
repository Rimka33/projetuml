<x-app-layout>
    <div class="app-card app-card-account shadow-sm d-flex flex-column">
        <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h4 class="app-card-title">Besoins Budgétaires du Département</h4>
                </div>
                <div class="col-auto">
                    <a href="{{ route('chef-departement.create-besoin') }}" class="btn app-btn-primary">
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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Montant (FCFA)</th>
                            <th>Priorité</th>
                            <th>Statut</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($besoins as $besoin)
                            <tr>
                                <td>{{ $besoin->description }}</td>
                                <td>{{ number_format($besoin->montant, 0, ',', ' ') }}</td>
                                <td>
                                    @if($besoin->priorite === 'high')
                                        <span class="badge bg-danger">Haute</span>
                                    @elseif($besoin->priorite === 'medium')
                                        <span class="badge bg-warning">Moyenne</span>
                                    @else
                                        <span class="badge bg-info">Basse</span>
                                    @endif
                                </td>
                                <td>
                                    @if($besoin->status === 'pending')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($besoin->status === 'approved')
                                        <span class="badge bg-success">Approuvé</span>
                                    @else
                                        <span class="badge bg-danger">Rejeté</span>
                                    @endif
                                </td>
                                <td>{{ $besoin->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="#" class="btn btn-sm app-btn-secondary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($besoin->status === 'pending')
                                            <a href="#" class="btn btn-sm app-btn-secondary ms-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="#" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm app-btn-secondary ms-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce besoin ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">
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
</x-app-layout>
