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
        Schema::create('paiment_admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained('admissions')->onDelete('cascade');
            $table->integer('montant');
            $table->enum('status', ['Paye', 'Non Paye'])->default('Non Paye');
            $table->enum('type', ['espece', 'cheque', 'virement'])->default('espece');
            //$table->timestamps('date_paiement');
            $table->foreignUlid('added_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiment_admissions');
    }
};
