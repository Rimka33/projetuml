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
            $table->unsignedBigInteger('validated_by')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('motif_rejet')->nullable();

            $table->foreign('validated_by')->references('id')->on('utilisateurs');
            $table->foreign('rejected_by')->references('id')->on('utilisateurs');
            $table->foreign('approved_by')->references('id')->on('utilisateurs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('besoin_budgetaires', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropForeign(['approved_by']);

            $table->dropColumn([
                'validated_by',
                'validated_at',
                'rejected_by',
                'rejected_at',
                'approved_by',
                'approved_at',
                'motif_rejet'
            ]);
        });
    }
};
