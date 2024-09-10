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
        Schema::create('paiement_inscriptions', function (Blueprint $table) {
            $table->id();
            $table->date('date_paiement');
            $table->string('numero_paiement');
            $table->enum('type_paiement', ['espece', 'cheque', 'virement banquaire'])->default('espece');
            $table->enum('statut_paiement', ['not paid', 'paid'])->default('paid');
            $table->foreignId('inscription_id')->constrained('inscriptions')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('montant_paye', 8, 2); // Montant payé
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_inscriptions');
    }
};
