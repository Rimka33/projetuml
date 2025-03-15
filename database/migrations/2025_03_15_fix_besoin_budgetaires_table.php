<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('besoin_budgetaires', function (Blueprint $table) {
            // Vérifier si les colonnes existent avant de les ajouter
            if (!Schema::hasColumn('besoin_budgetaires', 'validated_by')) {
                $table->unsignedBigInteger('validated_by')->nullable();
                $table->foreign('validated_by')->references('id')->on('utilisateurs')->onDelete('set null');
            }

            if (!Schema::hasColumn('besoin_budgetaires', 'validated_at')) {
                $table->timestamp('validated_at')->nullable();
            }

            if (!Schema::hasColumn('besoin_budgetaires', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable();
                $table->foreign('rejected_by')->references('id')->on('utilisateurs')->onDelete('set null');
            }

            if (!Schema::hasColumn('besoin_budgetaires', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable();
            }

            if (!Schema::hasColumn('besoin_budgetaires', 'motif_rejet')) {
                $table->text('motif_rejet')->nullable();
            }

            if (!Schema::hasColumn('besoin_budgetaires', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->foreign('approved_by')->references('id')->on('utilisateurs')->onDelete('set null');
            }

            if (!Schema::hasColumn('besoin_budgetaires', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
        });
    }

    public function down()
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
                'motif_rejet',
                'approved_by',
                'approved_at'
            ]);
        });
    }
};
