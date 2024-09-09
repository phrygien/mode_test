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
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique(); // Matricule unique de l'élève
            $table->string('photo')->nullable();
            $table->string('nom'); // Nom de l'élève
            $table->string('prenom'); // Prénom de l'élève
            $table->date('date_naissance'); // Date de naissance
            $table->string('lieu_naissance'); // Lieu de naissance
            $table->string('nationalite')->default('Malagasy');
            $table->enum('genre', ['masculin', 'feminin']); // Genre
            $table->string('adresse'); // Adresse résidentielle
            $table->string('telephone')->nullable()->unique(); // Numéro de téléphone
            $table->string('email')->nullable()->unique(); // Adresse email
            $table->string('cin')->nullable()->unique();
            $table->foreignId('admission_id')->nullable();// chaque eleve a une admission
            $table->boolean('imported_from_file')->default(false);
            $table->boolean('admission_direct')->default(false);
            $table->enum('statut', ['inscrit', 'en attente', 'suspendu'])->default('inscrit'); // Statut de l'élève
            $table->foreignId('tuteur_id'); // Référence à la table des tuteurs
            $table->string('photo')->nullable(); // URL de la photo de l'élève
            $table->date('date_entree')->nullable(); // Date d'entrée dans l'établissement
            $table->date('date_sortie')->nullable(); // Date de sortie de l'élève
            $table->text('etat_sante')->nullable(); // Informations sur l'état de santé ou les allergies
            $table->foreignUlid('added_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade'); // user add
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
