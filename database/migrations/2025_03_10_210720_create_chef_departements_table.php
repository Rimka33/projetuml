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
        Schema::create('chef_departements', function (Blueprint $table) {
            $table->integer('id_chef_dept')->unique();
            $table->string('grade');
            $table->integer('professeur_id');
            $table->integer('departement_id');
            $table->date('date_nomination');
            $table->primary('id_chef_dept');
            
            $table->foreign('professeur_id')->references('id')->on('professeurs');   
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chef_departements');
    }
};
