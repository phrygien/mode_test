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
        Schema::create('presence_enseignant_par_cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignant_id')->constrained('enseignants')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('emploi_du_temps_id')->constrained('emploi_du_temps')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('statut', ['Présent', 'Absent', 'Retard', 'Maladie']); // Statut de présence
            $table->time('heure_arrivee')->nullable(); // Heure d'arrivée si en retard
            $table->time('heure_depart')->nullable(); // Heure de départ si applicable
            $table->text('remarques')->nullable(); // Remarques éventuelles (raison de l'absence, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presence_enseignant_par_cours');
    }
};
