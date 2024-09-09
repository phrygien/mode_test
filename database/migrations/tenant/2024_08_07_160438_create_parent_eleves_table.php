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
        Schema::create('parent_eleves', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('telephone')->unique()->nullable();
            $table->string('email')->nullable()->unique();
            $table->text('adresse');
            $table->string('photo')->nullable();
            $table->string('profession')->nullable()->unique();
            $table->foreignId('eleve_id')->constrained('eleves')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('lien_parente', ['père', 'mère', 'oncle']); // Lien de parenté avec l'élève (père, mère, oncle, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_eleves');
    }
};
