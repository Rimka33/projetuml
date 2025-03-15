document.addEventListener('DOMContentLoaded', function() {
    // Gestion du calcul automatique du coût total
    const quantiteInput = document.getElementById('quantite');
    const coutUnitaireInput = document.getElementById('cout_unitaire');
    const coutTotalInput = document.getElementById('cout_total');
    const typeSelect = document.getElementById('type');
    const autreTypeDiv = document.getElementById('autre_type_div');

    if (quantiteInput && coutUnitaireInput && coutTotalInput) {
        function calculateTotal() {
            const quantite = parseFloat(quantiteInput.value) || 0;
            const coutUnitaire = parseFloat(coutUnitaireInput.value) || 0;
            const total = quantite * coutUnitaire;
            coutTotalInput.value = total.toFixed(2);
        }

        quantiteInput.addEventListener('input', calculateTotal);
        coutUnitaireInput.addEventListener('input', calculateTotal);
    }

    // Gestion de l'affichage du champ "Autre type"
    if (typeSelect && autreTypeDiv) {
        typeSelect.addEventListener('change', function() {
            if (this.value === 'autres') {
                autreTypeDiv.style.display = 'block';
            } else {
                autreTypeDiv.style.display = 'none';
            }
        });
    }
});
