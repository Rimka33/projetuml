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
        Schema::create('conference_budgetaires', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->date('date_conference');
            $table->string('lieu_conference');
            $table->string('participants');
            $table->integer('directeur_id');
            $table->primary('id');
            
            $table->foreign('directeur_id')->references('id')->on('directeurs');           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_budgetaires');
    }
};
