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
        Schema::create('affectation_matiere_niveaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matiere_id')->constrained('matieres')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('niveau_id')->constrained('niveaux')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('trimestre_id');
            $table->integer('coefficient')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affectation_matiere_niveaux');
    }
};
