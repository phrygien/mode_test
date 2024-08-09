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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('logo')->nullable();
            $table->string('type')->default('Private');
            $table->integer('status')->nullable()->default(1);
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->integer('province_id')->nullable();
            $table->integer('region_id');
            $table->integer('district_id');
            $table->integer('commune_id');
            $table->string('address');
            $table->foreignUlid('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
