<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('administrateurs', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('password')->comment('Stocké avec cryptage');
            $table->timestamp('derniere_connexion')->nullable();
            $table->primary('id');
            $table->timestamps();
            
            // Remove this line for now - we'll add it in a separate migration
            // $table->foreign('id')->references('created_by')->on('utilisateurs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrateurs');
    }
};