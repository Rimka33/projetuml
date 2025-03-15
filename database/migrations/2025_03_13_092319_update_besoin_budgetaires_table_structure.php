<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('besoin_budgetaires', function (Blueprint $table) {
            // Supprimer les colonnes qui ne sont plus utilisées si elles existent
            $columnsToDrop = ['titre', 'montant', 'justification', 'type_demandeur'];
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('besoin_budgetaires', $column)) {
                    $table->dropColumn($column);
                }
            }

            // Ajouter les nouvelles colonnes avec les bonnes contraintes si elles n'existent pas
            $columnsToAdd = [
                'type' => 'string',
                'designation' => 'string',
                'quantite' => 'integer',
                'cout_unitaire' => 'decimal:15,2',
                'cout_total' => 'decimal:15,2',
                'motif' => 'text',
                'periode' => 'string',
                'source_financement' => 'string'
            ];

            foreach ($columnsToAdd as $column => $type) {
                if (!Schema::hasColumn('besoin_budgetaires', $column)) {
                    if ($type === 'decimal:15,2') {
                        $table->decimal($column, 15, 2);
                    } else {
                        $table->$type($column);
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('besoin_budgetaires', function (Blueprint $table) {
            // Restaurer les anciennes colonnes
            $table->string('titre')->nullable();
            $table->decimal('montant', 15, 2);
            $table->text('justification')->nullable();
            $table->string('type_demandeur')->nullable();

            // Supprimer les nouvelles colonnes
            $columnsToDrop = [
                'type',
                'designation',
                'quantite',
                'cout_unitaire',
                'cout_total',
                'motif',
                'periode',
                'source_financement'
            ];

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('besoin_budgetaires', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
