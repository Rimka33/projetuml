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
        Schema::create('allocation_budgetaires', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->decimal('montant_demande', 15, 2);
            $table->decimal('montant_alloue', 15, 2);
            $table->decimal('ecart', 15, 2);
            $table->string('commentaire');
            $table->integer('rectorat_id');
            $table->primary('id');
            
            $table->foreign('rectorat_id')->references('id')->on('rectorats');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocation_budgetaires');
    }
};
