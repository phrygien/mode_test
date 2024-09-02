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
        Schema::create('frais_admissions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->foreignId('cycle_id')->constrained('cycles');
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires');
            $table->foreignUlid('user_id')->constrained('users');
            $table->integer('montant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frais_admissions');
    }
};
