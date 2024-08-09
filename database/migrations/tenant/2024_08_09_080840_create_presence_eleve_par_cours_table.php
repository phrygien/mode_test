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
        Schema::create('presence_eleve_par_cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained('eleves')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('emploi_du_temps_id')->constrained('emploi_du_temps')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('statut', ['present', 'absent', 'retard'])->default('present'); // Statut de présence
            $table->time('heure_arrivee')->nullable(); // Heure d'arrivée si en retard
            $table->string('motif')->nullable(); // Motif de l'absence ou du retard
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presence_eleve_par_cours');
    }
};
