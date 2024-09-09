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
        Schema::create('document_candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidature_id')->constrained('candidatures')->onUpdate('cascade')->onDelete('cascade');
            $table->string('doc_name'); // ex: certificat de scolarité, carte d'etude precedent, acienne buletin
            $table->string('file'); // ex: jpg, pdf, png
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_candidatures');
    }
};
