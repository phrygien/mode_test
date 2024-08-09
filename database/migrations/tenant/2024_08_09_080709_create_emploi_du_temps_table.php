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
        Schema::create('emploi_du_temps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained('matieres')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('enseignant_id')->constrained('enseignants')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date_cours'); // Date du cours
            $table->time('heure_debut'); // Heure de début du cours
            $table->time('heure_fin'); // Heure de fin du cours
            $table->string('salle')->nullable(); // Salle de classe
            $table->enum('statut', ['en cours', 'fini', 'annule'])->default('en cours');
            $table->enum('creneau_horaire', ['7h-9h', '9h30-11h30', '14h-16h', '16h-18h']); // Créneau horaire
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('trimestre_id')->constrained('trimestres')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emploi_du_temps');
    }
};
