<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pestdesease', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama penyakit atau hama
            $table->text('description')->nullable(); // Deskripsi
            $table->text('warning')->nullable(); // Peringatan atau dampak negatif
            $table->string('genus')->nullable(); // Genus
            $table->string('scientific_name')->nullable(); // Nama ilmiah
            $table->text('aliases')->nullable(); // Nama alternatif
            $table->text('symptoms')->nullable(); // Gejala yang ditimbulkan
            $table->json('solutions')->nullable(); // Solusi dalam format JSON
            $table->string('source')->nullable(); // Sumber atau referensi informasi
            $table->timestamps(); // Created at dan Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pestdesease');
    }
};
