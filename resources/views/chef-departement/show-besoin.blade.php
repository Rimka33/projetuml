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

        <div class="app-card app-card-account shadow-sm d-flex flex-column">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Détails du Besoin Budgétaire</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('chef-departement.dashboard') }}" class="btn app-btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>

            <div class="app-card-body px-4 w-100">
                @if($besoin->status === 'approved_by_rf')
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn app-btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-times me-2"></i>Rejeter
                                </button>
                                <form action="{{ route('chef-departement.validate-besoin', $besoin->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn app-btn-primary" onclick="return confirm('Êtes-vous sûr de vouloir valider ce besoin ?')">
                                        <i class="fas fa-check me-2"></i>Valider
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Demandeur</strong></div>
                            <div class="item-data">{{ $besoin->utilisateur->nom }} {{ $besoin->utilisateur->prenom }}</div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Type</strong></div>
                            <div class="item-data">
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Désignation</strong></div>
                            <div class="item-data">{{ $besoin->designation }}</div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Description/Motif</strong></div>
                            <div class="item-data">{{ $besoin->motif }}</div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Quantité</strong></div>
                            <div class="item-data">{{ $besoin->quantite }}</div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Coût Unitaire</strong></div>
                            <div class="item-data">{{ number_format($besoin->cout_unitaire, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Coût Total</strong></div>
                            <div class="item-data">{{ number_format($besoin->cout_total, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Période</strong></div>
                            <div class="item-data">{{ $besoin->periode }}</div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Source de Financement</strong></div>
                            <div class="item-data">{{ $besoin->source_financement }}</div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Priorité</strong></div>
                            <div class="item-data">
                                <span class="badge bg-{{ $besoin->priorite === 'high' ? 'danger' : ($besoin->priorite === 'medium' ? 'warning' : 'success') }}">
                                    {{ $besoin->priorite === 'high' ? 'Haute' : ($besoin->priorite === 'medium' ? 'Moyenne' : 'Basse') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Statut</strong></div>
                            <div class="item-data">
                                <span class="badge bg-{{ $besoin->status_color }}">
                                    {{ $besoin->status_label }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($besoin->validated_by)
                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Validé par</strong></div>
                            <div class="item-data">
                                {{ $besoin->validatedBy->nom }} {{ $besoin->validatedBy->prenom }}
                                @if($besoin->validated_at)
                                    le {{ \Carbon\Carbon::parse($besoin->validated_at)->format('d/m/Y H:i') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($besoin->rejected_by)
                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Rejeté par</strong></div>
                            <div class="item-data">
                                {{ $besoin->rejectedBy->nom }} {{ $besoin->rejectedBy->prenom }}
                                @if($besoin->rejected_at)
                                    le {{ \Carbon\Carbon::parse($besoin->rejected_at)->format('d/m/Y H:i') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if($besoin->motif_rejet)
                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <div class="item-label"><strong>Motif du rejet</strong></div>
                            <div class="item-data">{{ $besoin->motif_rejet }}</div>
                        </div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>

        <!-- Modal de rejet -->
        @if($besoin->status === 'pending' && $besoin->utilisateur_id !== auth()->id())
            <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Rejeter le besoin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('chef-departement.reject-besoin', $besoin->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="motif_rejet" class="form-label">Motif du rejet</label>
                                    <textarea class="form-control" id="motif_rejet" name="motif_rejet" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn app-btn-danger">Rejeter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
