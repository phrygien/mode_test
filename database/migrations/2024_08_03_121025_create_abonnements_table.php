<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->ulid('numero_abonnement');
            $table->timestamp('date_debut_abonnement');
            $table->timestamp('date_fin_abonnement');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_trial')->default(true);
            $table->timestamp('trial_ends_at')->nullable();
            $table->foreignId('plan_id');
            $table->foreignUlid('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonnements');
    }
};
