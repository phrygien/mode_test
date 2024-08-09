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
            $table->string('type_paiement')->default('espece');
            $table->string('statut_paiement')->default('non payé'); // non payé, payé, annule
            $table->foreignId('inscription_id')->constrained('inscriptions')->onDelete('cascade')->onUpdate('cascade');
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
