<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('besoin_budgetaires', function (Blueprint $table) {
            // Supprimer les anciennes colonnes
            $table->dropColumn(['titre', 'montant', 'justification', 'type_demandeur']);

            // Ajouter les nouvelles colonnes
            $table->string('type')->nullable();
            $table->string('designation')->nullable();
            $table->string('quantite')->nullable();
            $table->decimal('cout_unitaire', 15, 2)->nullable();
            $table->decimal('cout_total', 15, 2)->nullable();
            $table->text('motif')->nullable();
            $table->string('periode')->nullable();
            $table->string('source_financement')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('besoin_budgetaires', function (Blueprint $table) {
            // Restaurer les anciennes colonnes
            $table->string('titre')->nullable();
            $table->decimal('montant', 15, 2);
            $table->text('justification')->nullable();
            $table->string('type_demandeur')->nullable();

            // Supprimer les nouvelles colonnes
            $table->dropColumn([
                'type',
                'designation',
                'quantite',
                'cout_unitaire',
                'cout_total',
                'motif',
                'periode',
                'source_financement'
            ]);
        });
    }
};