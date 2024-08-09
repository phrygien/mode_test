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
        Schema::create('note_interogation_surprises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained(); // L'élève concerné
            $table->foreignId('interrogation_surprise_id')->constrained('interogation_surprises'); // Lien avec l'interrogation surprise
            $table->decimal('note', 5, 2); // Note obtenue
            $table->foreignUlid('added_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_interogation_surprises');
    }
};
