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
        Schema::create('tuteurs', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('nom'); // Nom du tuteur
            $table->string('prenom')->nullable(); // Prénom du tuteur
            $table->string('adresse')->nullable(); // Adresse résidentielle
            $table->string('telephone')->unique(); // Numéro de téléphone
            $table->string('email')->nullable()->unique(); // Adresse email
            $table->string('profession')->nullable(); // Profession du tuteur
            $table->enum('lien_parente', ['père', 'mère', 'oncle'])->default('père'); // Lien de parenté avec l'élève (père, mère, oncle, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuteurs');
    }
};
