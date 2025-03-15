<x-app-layout>
    <div class="container-xl">
        <div class="row g-6 settings-section">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="app-page-title mb-0">Exprimer un Besoin Budgétaire</h1>
                    <a href="{{ route('responsable-financier.dashboard') }}" class="btn app-btn-secondary">
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

                        <!-- Étape 1 : Sélectionner le type de besoin -->
                        <div id="step1">
                            <div class="mb-3">
                                <label for="besoin_type_select" class="form-label">Type de Besoin</label>
                                <select class="form-control" id="besoin_type_select" required>
                                    <option value="">Sélectionner le type de besoin</option>
                                    <option value="materiel_cours">Matériel de cours</option>
                                    <option value="materiel_imprimerie">Matériel d'imprimerie</option>
                                    <option value="projet_travaux">Projet de travaux</option>
                                    <option value="materiel_roulant">Matériel roulant</option>
                                    <option value="autres">Autres</option>
                                </select>
                            </div>
                        </div>

                        <!-- Étape 2 : Pour le type "Autres", demander le nom personnalisé -->
                        <div id="step2" style="display:none;">
                            <div class="mb-3">
                                <label for="custom_type" class="form-label">Nom du Type de Besoin</label>
                                <input type="text" class="form-control" id="custom_type" name="custom_type" placeholder="Saisir le nom du type de besoin">
                            </div>
                            <button type="button" id="confirm_custom_type" class="btn app-btn-primary">Confirmer</button>
                        </div>

                        <!-- Étape 3 : Affichage du formulaire complet -->
                        <form id="main_form" class="settings-form" method="POST" action="{{ route('responsable-financier.store-besoin') }}" style="display:none;">
                            @csrf
                            <!-- Champ caché pour stocker le type sélectionné (ou personnalisé) -->
                            <input type="hidden" id="selected_type" name="type" value="">

                            <!-- Groupe 1 : pour Matériel de cours, Matériel d'imprimerie, Matériel roulant -->
                            <div id="group1" style="display:none;">
                                <div class="mb-3">
                                    <label for="designation1" class="form-label">Désignation</label>
                                    <input type="text" class="form-control" id="designation1" name="designation1" placeholder="Liste des items" required value="{{ old('designation1') }}" tabindex="0">
                                    @error('designation1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="motif1" class="form-label">Description</label>
                                    <textarea class="form-control" id="motif1" name="motif1" placeholder="Décrivez le besoin" required tabindex="0">{{ old('motif1') }}</textarea>
                                    @error('motif1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="quantite1" class="form-label">Quantité</label>
                                    <input type="number" class="form-control" id="quantite1" name="quantite1" placeholder="Ex: 5" required value="{{ old('quantite1') }}" tabindex="0">
                                    @error('quantite1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cout_unitaire1" class="form-label">Coût Unitaire (FCFA)</label>
                                    <input type="number" step="0.01" class="form-control" id="cout_unitaire1" name="cout_unitaire1" placeholder="Ex: 50000" required value="{{ old('cout_unitaire1') }}" tabindex="0">
                                    @error('cout_unitaire1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cout_total1" class="form-label">Coût Total (calculé automatiquement)</label>
                                    <input type="number" step="0.01" class="form-control" id="cout_total1" name="cout_total1" placeholder="Totaux" readonly value="{{ old('cout_total1') }}" tabindex="0">
                                    @error('cout_total1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Groupe 2 : pour Projet de travaux et Autres -->
                            <div id="group2" style="display:none;">
                                <div class="mb-3">
                                    <label for="designation2" class="form-label">Désignation</label>
                                    <input type="text" class="form-control" id="designation2" name="designation2" placeholder="Liste des items" required value="{{ old('designation2') }}" tabindex="0">
                                    @error('designation2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="motif2" class="form-label">Description</label>
                                    <textarea class="form-control" id="motif2" name="motif2" placeholder="Décrivez le besoin" required tabindex="0">{{ old('motif2') }}</textarea>
                                    @error('motif2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="quantite2" class="form-label">Quantité</label>
                                    <input type="number" class="form-control" id="quantite2" name="quantite2" placeholder="Ex: 5" required value="{{ old('quantite2') }}" tabindex="0">
                                    @error('quantite2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cout_unitaire2" class="form-label">Coût Unitaire (FCFA)</label>
                                    <input type="number" step="0.01" class="form-control" id="cout_unitaire2" name="cout_unitaire2" placeholder="Ex: 50000" required value="{{ old('cout_unitaire2') }}" tabindex="0">
                                    @error('cout_unitaire2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cout_total2" class="form-label">Coût Total (calculé automatiquement)</label>
                                    <input type="number" step="0.01" class="form-control" id="cout_total2" name="cout_total2" placeholder="Totaux" readonly value="{{ old('cout_total2') }}" tabindex="0">
                                    @error('cout_total2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="periode" class="form-label">Période</label>
                                <input type="text" class="form-control" id="periode" name="periode" required value="{{ old('periode') }}" tabindex="0">
                                @error('periode')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="source_financement" class="form-label">Source de Financement</label>
                                <input type="text" class="form-control" id="source_financement" name="source_financement" required value="{{ old('source_financement') }}" tabindex="0">
                                @error('source_financement')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="priorite" class="form-label">Priorité</label>
                                <select class="form-control" id="priorite" name="priorite" required tabindex="0">
                                    <option value="low">Basse</option>
                                    <option value="medium" selected>Moyenne</option>
                                    <option value="high">Haute</option>
                                </select>
                                @error('priorite')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn app-btn-primary" tabindex="0">Enregistrer le Besoin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const mainForm = document.getElementById('main_form');
            const group1 = document.getElementById('group1');
            const group2 = document.getElementById('group2');
            const besoinTypeSelect = document.getElementById('besoin_type_select');
            const customTypeInput = document.getElementById('custom_type');
            const confirmCustomTypeBtn = document.getElementById('confirm_custom_type');
            const selectedType = document.getElementById('selected_type');

            // Éléments du groupe 1
            const quantite1 = document.getElementById('quantite1');
            const coutUnitaire1 = document.getElementById('cout_unitaire1');
            const coutTotal1 = document.getElementById('cout_total1');

            // Éléments du groupe 2
            const quantite2 = document.getElementById('quantite2');
            const coutUnitaire2 = document.getElementById('cout_unitaire2');
            const coutTotal2 = document.getElementById('cout_total2');

            function calculateTotal(quantite, coutUnitaire, coutTotalElement) {
                if (quantite && coutUnitaire) {
                    const total = parseFloat(quantite) * parseFloat(coutUnitaire);
                    coutTotalElement.value = !isNaN(total) ? total.toFixed(2) : '';
                }
            }

            // Gestionnaires d'événements pour le groupe 1
            if (quantite1 && coutUnitaire1 && coutTotal1) {
                [quantite1, coutUnitaire1].forEach(input => {
                    input.addEventListener('input', () => {
                        calculateTotal(quantite1.value, coutUnitaire1.value, coutTotal1);
                    });
                });
            }

            // Gestionnaires d'événements pour le groupe 2
            if (quantite2 && coutUnitaire2 && coutTotal2) {
                [quantite2, coutUnitaire2].forEach(input => {
                    input.addEventListener('input', () => {
                        calculateTotal(quantite2.value, coutUnitaire2.value, coutTotal2);
                    });
                });
            }

            besoinTypeSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                if (selectedValue === 'autres') {
                    step2.style.display = 'block';
                    mainForm.style.display = 'none';
                } else if (selectedValue) {
                    step2.style.display = 'none';
                    mainForm.style.display = 'block';
                    selectedType.value = selectedValue;

                    // Afficher le groupe approprié
                    if (['materiel_cours', 'materiel_imprimerie', 'materiel_roulant'].includes(selectedValue)) {
                        group1.style.display = 'block';
                        group2.style.display = 'none';
                        // Désactiver les champs requis du groupe 2
                        const group2Inputs = group2.querySelectorAll('input[required], textarea[required]');
                        group2Inputs.forEach(input => input.required = false);
                        // Activer les champs requis du groupe 1
                        const group1Inputs = group1.querySelectorAll('input[required], textarea[required]');
                        group1Inputs.forEach(input => input.required = true);
                    } else {
                        group1.style.display = 'none';
                        group2.style.display = 'block';
                        // Désactiver les champs requis du groupe 1
                        const group1Inputs = group1.querySelectorAll('input[required], textarea[required]');
                        group1Inputs.forEach(input => input.required = false);
                        // Activer les champs requis du groupe 2
                        const group2Inputs = group2.querySelectorAll('input[required], textarea[required]');
                        group2Inputs.forEach(input => input.required = true);
                    }
                }
            });

            confirmCustomTypeBtn.addEventListener('click', function() {
                const customTypeValue = customTypeInput.value.trim();
                if (customTypeValue) {
                    step2.style.display = 'none';
                    mainForm.style.display = 'block';
                    selectedType.value = customTypeValue;
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

            // Validation du formulaire avant soumission
            mainForm.addEventListener('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                let errorMessage = '';

                // Vérifier le type
                if (!selectedType.value) {
                    isValid = false;
                    errorMessage += 'Le type de besoin est requis.\n';
                }

                // Vérifier les champs du groupe actif
                const activeGroup = ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant'].includes(selectedType.value) ? group1 : group2;
                const groupSuffix = activeGroup === group1 ? '1' : '2';

                const designation = document.getElementById('designation' + groupSuffix);
                const motif = document.getElementById('motif' + groupSuffix);
                const quantite = document.getElementById('quantite' + groupSuffix);
                const coutUnitaire = document.getElementById('cout_unitaire' + groupSuffix);
                const coutTotal = document.getElementById('cout_total' + groupSuffix);
                const periode = document.getElementById('periode');
                const sourceFinancement = document.getElementById('source_financement');
                const priorite = document.getElementById('priorite');

                if (!designation.value.trim()) {
                    isValid = false;
                    errorMessage += 'La désignation est requise.\n';
                }

                if (!motif.value.trim()) {
                    isValid = false;
                    errorMessage += 'Le motif est requis.\n';
                }

                if (!quantite.value || quantite.value < 1) {
                    isValid = false;
                    errorMessage += 'La quantité doit être supérieure à 0.\n';
                }

                if (!coutUnitaire.value || coutUnitaire.value <= 0) {
                    isValid = false;
                    errorMessage += 'Le coût unitaire doit être supérieur à 0.\n';
                }

                if (!coutTotal.value || coutTotal.value <= 0) {
                    isValid = false;
                    errorMessage += 'Le coût total doit être supérieur à 0.\n';
                }

                if (!periode.value.trim()) {
                    isValid = false;
                    errorMessage += 'La période est requise.\n';
                }

                if (!sourceFinancement.value.trim()) {
                    isValid = false;
                    errorMessage += 'La source de financement est requise.\n';
                }

                if (!priorite.value) {
                    isValid = false;
                    errorMessage += 'La priorité est requise.\n';
                }

                if (!isValid) {
                    alert('Veuillez corriger les erreurs suivantes :\n\n' + errorMessage);
                } else {
                    // Soumettre le formulaire
                    this.submit();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
