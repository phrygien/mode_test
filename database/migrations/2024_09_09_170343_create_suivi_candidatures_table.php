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
        Schema::create('suivi_candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidature_id')->constrained('candidatures')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['en cours de verification', 'verified', 'incomplete', 'acepted', 'declined'])->default('en cours de verification'); // suivi evolutions candidature 
            $table->foreignUlid('updated_by')->constrained('users')->onUpdate('cascade');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suivi_candidatures');
    }
};
