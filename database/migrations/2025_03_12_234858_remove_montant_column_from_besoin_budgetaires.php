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
        Schema::table('besoin_budgetaires', function (Blueprint $table) {
            if (Schema::hasColumn('besoin_budgetaires', 'montant')) {
                $table->decimal('montant', 15, 2)->nullable()->change();
                $table->dropColumn('montant');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('besoin_budgetaires', function (Blueprint $table) {
            if (!Schema::hasColumn('besoin_budgetaires', 'montant')) {
                $table->decimal('montant', 15, 2)->nullable();
            }
        });
    }
};
