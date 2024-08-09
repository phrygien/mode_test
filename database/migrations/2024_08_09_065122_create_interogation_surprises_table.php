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
        Schema::create('interogation_surprises', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Exemple : "Interrogation Surprise 1"
            $table->foreignId('section_id')->constrained('sections')->onUpdate('cascade')->onDelete('cascade'); // Lien avec la section
            $table->foreignId('niveaux_id')->constrained('niveaux')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained('matieres')->onUpdate('cascade')->onDelete('cascade'); // Lien avec la matière
            $table->foreignId('trimestre_id')->constrained('trimestres')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date_interrogation'); // Date de l'interrogation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interogation_surprises');
    }
};
