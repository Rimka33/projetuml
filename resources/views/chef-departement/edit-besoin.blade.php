<x-app-layout>
    <div class="container-xl">
        <div class="row g-6 settings-section">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="app-page-title mb-0">Modifier un Besoin Budgétaire</h1>
                    <a href="{{ route('chef-departement.dashboard') }}" class="btn app-btn-secondary">
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

                        <form action="{{ route('chef-departement.update-besoin', $besoin->id) }}" method="POST" id="mainForm">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="type" id="selectedType" value="{{ $besoin->type }}">

                            <!-- Étape 1 : Sélectionner le type de besoin -->
                            <div id="step1">
                                <div class="mb-3">
                                    <label for="besoin_type_select" class="form-label">Type de Besoin</label>
                                    <select class="form-control" id="besoin_type_select" required>
                                        <option value="">Sélectionner le type de besoin</option>
                                        <option value="materiel_cours" {{ $besoin->type === 'materiel_cours' ? 'selected' : '' }}>Matériel de cours</option>
                                        <option value="materiel_imprimerie" {{ $besoin->type === 'materiel_imprimerie' ? 'selected' : '' }}>Matériel d'imprimerie</option>
                                        <option value="projet_travaux" {{ $besoin->type === 'projet_travaux' ? 'selected' : '' }}>Projet de travaux</option>
                                        <option value="materiel_roulant" {{ $besoin->type === 'materiel_roulant' ? 'selected' : '' }}>Matériel roulant</option>
                                        <option value="autres" {{ $besoin->type === 'autres' ? 'selected' : '' }}>Autres</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Groupe 1 : Pour matériel de cours, matériel d'imprimerie et matériel roulant -->
                            <div id="group1" style="display:none;">
                                <div class="mb-3">
                                    <label for="designation1" class="form-label">Désignation</label>
                                    <input type="text" class="form-control" id="designation1" name="designation1" value="{{ $besoin->designation }}" required>
                                    @error('designation1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="motif1" class="form-label">Description</label>
                                    <textarea class="form-control" id="motif1" name="motif1" required>{{ $besoin->motif }}</textarea>
                                    @error('motif1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="quantite1" class="form-label">Quantité</label>
                                    <input type="number" class="form-control" id="quantite1" name="quantite1" value="{{ $besoin->quantite }}" required>
                                    @error('quantite1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cout_unitaire1" class="form-label">Coût Unitaire (FCFA)</label>
                                    <input type="number" class="form-control" id="cout_unitaire1" name="cout_unitaire1" value="{{ $besoin->cout_unitaire }}" required>
                                    @error('cout_unitaire1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cout_total1" class="form-label">Coût Total (FCFA)</label>
                                    <input type="number" class="form-control" id="cout_total1" name="cout_total1" value="{{ $besoin->cout_total }}" readonly>
                                    @error('cout_total1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Groupe 2 : Pour projet de travaux et autres -->
                            <div id="group2" style="display:none;">
                                <div class="mb-3">
                                    <label for="designation2" class="form-label">Désignation</label>
                                    <input type="text" class="form-control" id="designation2" name="designation2" value="{{ $besoin->designation }}" required>
                                    @error('designation2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="motif2" class="form-label">Description</label>
                                    <textarea class="form-control" id="motif2" name="motif2" required>{{ $besoin->motif }}</textarea>
                                    @error('motif2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="quantite2" class="form-label">Quantité</label>
                                    <input type="number" class="form-control" id="quantite2" name="quantite2" value="{{ $besoin->quantite }}" required>
                                    @error('quantite2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cout_unitaire2" class="form-label">Coût Unitaire (FCFA)</label>
                                    <input type="number" class="form-control" id="cout_unitaire2" name="cout_unitaire2" value="{{ $besoin->cout_unitaire }}" required>
                                    @error('cout_unitaire2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cout_total2" class="form-label">Coût Total (FCFA)</label>
                                    <input type="number" class="form-control" id="cout_total2" name="cout_total2" value="{{ $besoin->cout_total }}" readonly>
                                    @error('cout_total2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Champs communs -->
                            <div class="mb-3">
                                <label for="periode" class="form-label">Période</label>
                                <select class="form-control" id="periode" name="periode" required>
                                    <option value="">Sélectionner la période</option>
                                    <option value="Q1" {{ $besoin->periode === 'Q1' ? 'selected' : '' }}>1er Quadrimestre</option>
                                    <option value="Q2" {{ $besoin->periode === 'Q2' ? 'selected' : '' }}>2ème Quadrimestre</option>
                                    <option value="Q3" {{ $besoin->periode === 'Q3' ? 'selected' : '' }}>3ème Quadrimestre</option>
                                </select>
                                @error('periode')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="source_financement" class="form-label">Source de Financement</label>
                                <select class="form-control" id="source_financement" name="source_financement" required>
                                    <option value="">Sélectionner la source de financement</option>
                                    <option value="budget_fonctionnement" {{ $besoin->source_financement === 'budget_fonctionnement' ? 'selected' : '' }}>Budget de Fonctionnement</option>
                                    <option value="budget_investissement" {{ $besoin->source_financement === 'budget_investissement' ? 'selected' : '' }}>Budget d'Investissement</option>
                                    <option value="recettes_propres" {{ $besoin->source_financement === 'recettes_propres' ? 'selected' : '' }}>Recettes Propres</option>
                                </select>
                                @error('source_financement')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="priorite" class="form-label">Niveau de Priorité</label>
                                <select class="form-control" id="priorite" name="priorite" required>
                                    <option value="">Sélectionner le niveau de priorité</option>
                                    <option value="low" {{ $besoin->priorite === 'low' ? 'selected' : '' }}>Basse</option>
                                    <option value="medium" {{ $besoin->priorite === 'medium' ? 'selected' : '' }}>Moyenne</option>
                                    <option value="high" {{ $besoin->priorite === 'high' ? 'selected' : '' }}>Haute</option>
                                </select>
                                @error('priorite')
                                    <div class="text-danger">{{ $message }}</div>
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
            const mainForm = document.getElementById('mainForm');
            const step1 = document.getElementById('step1');
            const group1 = document.getElementById('group1');
            const group2 = document.getElementById('group2');
            const besoinTypeSelect = document.getElementById('besoin_type_select');
            const selectedType = document.getElementById('selectedType');

            const quantite1 = document.getElementById('quantite1');
            const coutUnitaire1 = document.getElementById('cout_unitaire1');
            const coutTotal1 = document.getElementById('cout_total1');

            const quantite2 = document.getElementById('quantite2');
            const coutUnitaire2 = document.getElementById('cout_unitaire2');
            const coutTotal2 = document.getElementById('cout_total2');

            function calculateTotal(quantite, coutUnitaire, coutTotalInput) {
                const total = quantite * coutUnitaire;
                coutTotalInput.value = total;
            }

            if (quantite1 && coutUnitaire1 && coutTotal1) {
                [quantite1, coutUnitaire1].forEach(input => {
                    input.addEventListener('input', () => {
                        calculateTotal(quantite1.value, coutUnitaire1.value, coutTotal1);
                    });
                });
            }

            if (quantite2 && coutUnitaire2 && coutTotal2) {
                [quantite2, coutUnitaire2].forEach(input => {
                    input.addEventListener('input', () => {
                        calculateTotal(quantite2.value, coutUnitaire2.value, coutTotal2);
                    });
                });
            }

            // Afficher le groupe approprié au chargement
            const initialType = besoinTypeSelect.value;
            if (initialType) {
                selectedType.value = initialType;
                if (['materiel_cours', 'materiel_imprimerie', 'materiel_roulant'].includes(initialType)) {
                    group1.style.display = 'block';
                    group2.style.display = 'none';
                } else if (['projet_travaux', 'autres'].includes(initialType)) {
                    group1.style.display = 'none';
                    group2.style.display = 'block';
                }
            }

            besoinTypeSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                selectedType.value = selectedValue;

                if (['materiel_cours', 'materiel_imprimerie', 'materiel_roulant'].includes(selectedValue)) {
                    group1.style.display = 'block';
                    group2.style.display = 'none';
                    // Désactiver les champs requis du groupe 2
                    const group2Inputs = group2.querySelectorAll('input[required], textarea[required]');
                    group2Inputs.forEach(input => input.required = false);
                    // Activer les champs requis du groupe 1
                    const group1Inputs = group1.querySelectorAll('input[required], textarea[required]');
                    group1Inputs.forEach(input => input.required = true);
                } else if (['projet_travaux', 'autres'].includes(selectedValue)) {
                    group1.style.display = 'none';
                    group2.style.display = 'block';
                    // Désactiver les champs requis du groupe 1
                    const group1Inputs = group1.querySelectorAll('input[required], textarea[required]');
                    group1Inputs.forEach(input => input.required = false);
                    // Activer les champs requis du groupe 2
                    const group2Inputs = group2.querySelectorAll('input[required], textarea[required]');
                    group2Inputs.forEach(input => input.required = true);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
