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
        Schema::create('examens', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('periode_examen_id')->constrained(); // Lien avec la période d'examen
            $table->foreignId('section_id')->constrained(); // Lien avec la section
            $table->date('date_examen');
            $table->enum('status', ['en cours', 'terminé', 'annule', 'en entente'])->default('en entente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examens');
    }
};
