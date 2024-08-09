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
        Schema::create('planing_paiement_frais_scolarites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained('eleves')->onDelete('cascade');
            $table->foreignId('frais_scolarites_id')->constrained('frais_scolarites')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onDelete('cascade');
            $table->date('mois_concerne'); // Mois pour lequel le paiement est prévu
            $table->enum('statut', ['non payé', 'partiellement payé', 'payé'])->default('non payé');
            $table->decimal('montant_reste', 10, 2)->nullable(); // Montant restant à payer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planing_paiement_frais_scolarites');
    }
};
