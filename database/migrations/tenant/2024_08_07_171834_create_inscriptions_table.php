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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_inscription')->unique();
            $table->date('date_inscription');
            $table->foreignId('eleve_id')->constrained('eleves')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('niveaux_id')->constrained('niveaux')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cycle_id')->constrained('cycles')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('statut', ['en attente', 'confirmée', 'annulée', 'terminée'])->default('en attente'); // 'en attente', 'confirmée', 'annulée', 'terminée'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
