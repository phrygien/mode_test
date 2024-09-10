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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();

            // infos curent scolaire
            $table->string('current_school');
            $table->foreignId('curent_cycle')->constrained('cycles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('current_niveau')->constrained('niveaux')->onUpdate('cascade');

            // infos scolaire demande
            $table->foreignId('cycle_demande')->constrained('cycles')->onUpdate('cascade'); // cycle demande
            $table->foreignId('niveau_demande')->constrained('niveaux')->onUpdate('cascade')->onDelete('cascade');

            // infos personnelles
            $table->string('photo')->nullable(); // photo d'identite
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->date('date_naissance');
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->default('Malagasy');
            $table->enum('genre', ['masculin', 'feminin']); // Genre
            $table->string('adresse'); // Adresse résidentielle
            $table->string('telephone')->nullable()->unique(); // Numéro de téléphone
            $table->string('email')->nullable()->unique(); // Adresse email
            $table->string('cin')->nullable()->unique();

            // infos famille
            $table->string('nom_pere');
            $table->string('prenom_pere')->nullable();
            $table->string('phone_pere')->unique()->nullable();
            $table->string('email_pere')->unique()->nullable();
            $table->string('profession_pere')->nullable();
            $table->string('adresse_pere');

            //info famille mere
            $table->string('mere');
            $table->string('fonction_mere')->nullable();
            $table->string('phone_mere')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->text('adresse_mere')->nullable(); // si different du pere ou de l'eleves

            // infos candidature
            $table->string('reference_candidature')->unique();
            $table->enum('type_candidature', ['general', 'transfert'])->default('general');
            $table->string('status')->default('En cours'); // "En cours", "Validée", "Rejetée"
            $table->boolean('is_document_complete')->default(false); // Pour la verification des documents obligatoires
            $table->foreignUlid('aded_by')->constrained('users')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
