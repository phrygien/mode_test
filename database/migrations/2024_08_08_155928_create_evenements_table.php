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
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('photo')->nullable();
            $table->enum('raison', ['fete', 'renuion', 'convocation', 'voyages', 'etude', 'autres'])->default('renuion');
            $table->dateTime('date_evenement');
            $table->string('statut')->default('en entente');
            $table->text('description');
            $table->foreignUlid('user_add')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenements');
    }
};
