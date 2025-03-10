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
        Schema::create('utilisateurs', function (Blueprint $table) {
        $table->integer('id_integer')->unique();
        $table->string('nom');
        $table->string('prenom');
        $table->string('email');
        $table->string('role');
        $table->date('date_creation');
        $table->integer('created_by');
        $table->string('status');
        $table->primary('id_integer');
        $table->unique('created_by');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
