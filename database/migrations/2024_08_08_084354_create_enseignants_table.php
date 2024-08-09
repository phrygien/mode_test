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
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('email')->unique();
            $table->string('telephone')->unique();
            $table->string('cin')->nullable();
            $table->string('sexe');
            $table->date('date_naissance');
            $table->string('lieu_naissance')->nullable();
            $table->string('photo')->nullable();
            $table->text('adresse');
            $table->date('date_embauche');
            $table->enum('mode_paiement', ['mensuel', 'horaire'])->default('mensuel'); // Mode de paiement
            $table->boolean('actif')->default(true);
            $table->foreignUlid('added_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
