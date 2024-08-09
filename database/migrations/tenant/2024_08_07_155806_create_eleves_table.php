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
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->date('date_naissance');
            $table->string('lieu_naissance')->nullable();
            $table->string('sexe');
            $table->string('cin')->nullable()->unique();
            $table->string('telephone')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('imatricule')->nullable();
            $table->string('adresse')->nullable();
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
