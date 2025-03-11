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
            $table->id();
            $table->foreignId('directeur_id')->constrained('directeurs');
            $table->string('status');
            $table->date('date_conference');
            $table->text('commentaires')->nullable();
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
