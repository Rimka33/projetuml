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
        Schema::create('admin_actions_logs', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->integer('admin_id');
            $table->string('action_type')->comment('CREATE_USER, UPDATE_USER, ASSIGN_DEPT, etc.');
            $table->string('entity_type')->comment('DIRECTEUR, PROFESSEUR, CHEF_DEPT, etc.');
            $table->integer('entity_id');
            $table->json('old_values')->comment('Anciennes valeurs pour les mises à jour');
            $table->json('new_values')->comment('Nouvelles valeurs');
            $table->timestamp('action_date');
            $table->string('ip_address');
            $table->primary('id');
            
            $table->foreign('admin_id')->references('id')->on('administrateurs');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_actions_logs');
    }
};
