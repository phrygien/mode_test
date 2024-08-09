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
        Schema::create('periode_examens', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Exemple : "Examen du Premier Trimestre"
            $table->foreignId('trimestre_id')->constrained(); // Lien avec le trimestre
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['en cours', 'finis', 'en attente'])->default('en attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_examens');
    }
};
