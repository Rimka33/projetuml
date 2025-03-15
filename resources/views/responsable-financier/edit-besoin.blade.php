<x-app-layout>
    <div class="container-xl">
        <div class="row g-6 settings-section">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="app-page-title mb-0">Modifier un Besoin Budgétaire</h1>
                    <a href="{{ route('responsable-financier.show-besoin', $besoin->id) }}" class="btn app-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
            <div class="col-12">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('responsable-financier.update-besoin', $besoin->id) }}" method="POST" id="besoinForm">
                            @csrf
                            @method('PUT')

                            <!-- Type de Besoin -->
                            <div class="mb-3">
                                <label for="type" class="form-label">Type de Besoin</label>
                                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Sélectionner le type de besoin</option>
                                    <option value="materiel_cours" {{ $besoin->type === 'materiel_cours' ? 'selected' : '' }}>Matériel de cours</option>
                                    <option value="materiel_imprimerie" {{ $besoin->type === 'materiel_imprimerie' ? 'selected' : '' }}>Matériel d'imprimerie</option>
                                    <option value="projet_travaux" {{ $besoin->type === 'projet_travaux' ? 'selected' : '' }}>Projet de travaux</option>
                                    <option value="materiel_roulant" {{ $besoin->type === 'materiel_roulant' ? 'selected' : '' }}>Matériel roulant</option>
                                    <option value="autres" {{ $besoin->type === 'autres' ? 'selected' : '' }}>Autres</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Groupe 1 (Matériel) -->
                            <div id="group1Fields" class="{{ in_array($besoin->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']) ? '' : 'd-none' }}">
                                <div class="mb-3">
                                    <label for="designation1" class="form-label">Désignation</label>
                                    <input type="text" class="form-control @error('designation1') is-invalid @enderror" id="designation1" name="designation1" value="{{ old('designation1', $besoin->designation) }}">
                                    @error('designation1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="motif1" class="form-label">Motif</label>
                                    <textarea class="form-control @error('motif1') is-invalid @enderror" id="motif1" name="motif1" rows="3">{{ old('motif1', $besoin->motif) }}</textarea>
                                    @error('motif1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="quantite1" class="form-label">Quantité</label>
                                    <input type="number" class="form-control @error('quantite1') is-invalid @enderror" id="quantite1" name="quantite1" value="{{ old('quantite1', $besoin->quantite) }}" min="1">
                                    @error('quantite1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cout_unitaire1" class="form-label">Coût Unitaire (FCFA)</label>
                                    <input type="number" class="form-control @error('cout_unitaire1') is-invalid @enderror" id="cout_unitaire1" name="cout_unitaire1" value="{{ old('cout_unitaire1', $besoin->cout_unitaire) }}" min="0">
                                    @error('cout_unitaire1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cout_total1" class="form-label">Coût Total (FCFA)</label>
                                    <input type="number" class="form-control @error('cout_total1') is-invalid @enderror" id="cout_total1" name="cout_total1" value="{{ old('cout_total1', $besoin->cout_total) }}" min="0">
                                    @error('cout_total1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Groupe 2 (Autres) -->
                            <div id="group2Fields" class="{{ in_array($besoin->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']) ? 'd-none' : '' }}">
                                <div class="mb-3">
                                    <label for="designation2" class="form-label">Désignation</label>
                                    <input type="text" class="form-control @error('designation2') is-invalid @enderror" id="designation2" name="designation2" value="{{ old('designation2', $besoin->designation) }}">
                                    @error('designation2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="motif2" class="form-label">Motif</label>
                                    <textarea class="form-control @error('motif2') is-invalid @enderror" id="motif2" name="motif2" rows="3">{{ old('motif2', $besoin->motif) }}</textarea>
                                    @error('motif2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="quantite2" class="form-label">Quantité</label>
                                    <input type="number" class="form-control @error('quantite2') is-invalid @enderror" id="quantite2" name="quantite2" value="{{ old('quantite2', $besoin->quantite) }}" min="1">
                                    @error('quantite2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cout_unitaire2" class="form-label">Coût Unitaire (FCFA)</label>
                                    <input type="number" class="form-control @error('cout_unitaire2') is-invalid @enderror" id="cout_unitaire2" name="cout_unitaire2" value="{{ old('cout_unitaire2', $besoin->cout_unitaire) }}" min="0">
                                    @error('cout_unitaire2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cout_total2" class="form-label">Coût Total (FCFA)</label>
                                    <input type="number" class="form-control @error('cout_total2') is-invalid @enderror" id="cout_total2" name="cout_total2" value="{{ old('cout_total2', $besoin->cout_total) }}" min="0">
                                    @error('cout_total2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Champs communs -->
                            <div class="mb-3">
                                <label for="periode" class="form-label">Période</label>
                                <input type="text" class="form-control @error('periode') is-invalid @enderror" id="periode" name="periode" value="{{ old('periode', $besoin->periode) }}" required>
                                @error('periode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="source_financement" class="form-label">Source de Financement</label>
                                <input type="text" class="form-control @error('source_financement') is-invalid @enderror" id="source_financement" name="source_financement" value="{{ old('source_financement', $besoin->source_financement) }}" required>
                                @error('source_financement')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="priorite" class="form-label">Priorité</label>
                                <select class="form-control @error('priorite') is-invalid @enderror" id="priorite" name="priorite" required>
                                    <option value="low" {{ $besoin->priorite === 'low' ? 'selected' : '' }}>Basse</option>
                                    <option value="medium" {{ $besoin->priorite === 'medium' ? 'selected' : '' }}>Moyenne</option>
                                    <option value="high" {{ $besoin->priorite === 'high' ? 'selected' : '' }}>Haute</option>
                                </select>
                                @error('priorite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn app-btn-primary">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const group1Fields = document.getElementById('group1Fields');
            const group2Fields = document.getElementById('group2Fields');

            function toggleFields() {
                const isGroup1 = ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant'].includes(typeSelect.value);
                group1Fields.classList.toggle('d-none', !isGroup1);
                group2Fields.classList.toggle('d-none', isGroup1);
            }

            typeSelect.addEventListener('change', toggleFields);

            // Calcul automatique du coût total pour le groupe 1
            const quantite1 = document.getElementById('quantite1');
            const coutUnitaire1 = document.getElementById('cout_unitaire1');
            const coutTotal1 = document.getElementById('cout_total1');

            function calculateTotal1() {
                if (quantite1.value && coutUnitaire1.value) {
                    coutTotal1.value = (parseFloat(quantite1.value) * parseFloat(coutUnitaire1.value)).toFixed(2);
                }
            }

            quantite1.addEventListener('input', calculateTotal1);
            coutUnitaire1.addEventListener('input', calculateTotal1);

            // Calcul automatique du coût total pour le groupe 2
            const quantite2 = document.getElementById('quantite2');
            const coutUnitaire2 = document.getElementById('cout_unitaire2');
            const coutTotal2 = document.getElementById('cout_total2');

            function calculateTotal2() {
                if (quantite2.value && coutUnitaire2.value) {
                    coutTotal2.value = (parseFloat(quantite2.value) * parseFloat(coutUnitaire2.value)).toFixed(2);
                }
            }

            quantite2.addEventListener('input', calculateTotal2);
            coutUnitaire2.addEventListener('input', calculateTotal2);
        });
    </script>
    @endpush
</x-app-layout>
