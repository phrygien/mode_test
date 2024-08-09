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
        Schema::create('examen_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examen_id')->constrained('examens'); // Associe un détail à un examen
            $table->foreignId('matiere_id')->constrained('matieres'); // Associe une matière à cet examen
            $table->string('sujet')->nullable(); // Sujet ou description de l'examen pour cette matière
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_details');
    }
};
