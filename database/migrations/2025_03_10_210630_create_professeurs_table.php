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
        Schema::create('professeurs', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('grade');
            $table->integer('utilisateur_id');
            $table->integer('departement_id');
            $table->primary('id');
            
            $table->foreign('utilisateur_id')->references('id_integer')->on('utilisateurs');         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professeurs');
    }
};
