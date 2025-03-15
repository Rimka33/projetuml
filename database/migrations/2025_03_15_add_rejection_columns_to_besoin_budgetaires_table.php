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
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->text('motif_rejet')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->foreign('rejected_by')
                ->references('id')
                ->on('utilisateurs')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('besoin_budgetaires', function (Blueprint $table) {
            $table->dropForeign(['rejected_by']);
            $table->dropColumn(['rejected_by', 'motif_rejet', 'rejected_at']);
        });
    }
};
