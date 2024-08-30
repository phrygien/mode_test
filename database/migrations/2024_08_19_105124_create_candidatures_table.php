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
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cycle_id')->constrained('cycles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('niveaux_id')->constrained('niveaux')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('lieu_naissance')->nullable();
            $table->string('sexe');
            $table->string('cin')->nullable()->unique();
            $table->string('adresse');
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('En cours'); // "En cours", "Validée", "Rejetée"
            $table->string('current_school');
            $table->text('motivation')->nullable();
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
