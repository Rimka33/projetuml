<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mettre à jour les valeurs existantes
        DB::table('besoin_budgetaires')
            ->where('priorite', 'basse')
            ->update(['priorite' => 'low']);

        DB::table('besoin_budgetaires')
            ->where('priorite', 'moyenne')
            ->update(['priorite' => 'medium']);

        DB::table('besoin_budgetaires')
            ->where('priorite', 'haute')
            ->update(['priorite' => 'high']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remettre les anciennes valeurs
        DB::table('besoin_budgetaires')
            ->where('priorite', 'low')
            ->update(['priorite' => 'basse']);

        DB::table('besoin_budgetaires')
            ->where('priorite', 'medium')
            ->update(['priorite' => 'moyenne']);

        DB::table('besoin_budgetaires')
            ->where('priorite', 'high')
            ->update(['priorite' => 'haute']);
    }
};
