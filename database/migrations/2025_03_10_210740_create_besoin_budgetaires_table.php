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
        Schema::create('besoin_budgetaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs');
            $table->foreignId('departement_id')->nullable()->constrained('departements');
            $table->string('titre')->nullable();
            $table->text('description');
            $table->decimal('montant', 15, 2);
            $table->string('priorite')->default('medium');
            $table->string('status')->default('pending');
            $table->text('justification')->nullable();
            $table->string('type_demandeur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('besoin_budgetaires');
    }
};
