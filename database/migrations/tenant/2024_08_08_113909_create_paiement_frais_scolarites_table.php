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
        Schema::create('paiement_frais_scolarites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_paiement_id');
            $table->decimal('montant_paye', 10, 2);
            $table->date('date_paiement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_frais_scolarites');
    }
};
