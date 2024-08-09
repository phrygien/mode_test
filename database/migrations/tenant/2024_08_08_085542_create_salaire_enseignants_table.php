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
        Schema::create('salaire_enseignants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignant_id')->constrained('enseignants')->onDelete('cascade');
            $table->decimal('salaire_mensuel', 10, 2)->nullable(); // Pour les paiements mensuels
            $table->decimal('taux_horaire', 10, 2)->nullable(); // Pour les paiements horaires
            $table->decimal('allocations', 10, 2)->nullable();
            $table->decimal('deductions', 10, 2)->nullable();
            $table->date('date_debut');
            $table->date('date_fin')->nullable(); // Optionnel si le salaire change au fil du temps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaire_enseignants');
    }
};
