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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('badge')->default('Produk'); // label badge untuk identifikasi produk
            $table->text('deskripsi');
            $table->json('manfaat')->nullable(); // disimpan sebagai JSON array untuk multiple benefits
            $table->decimal('harga', 15, 2)->nullable();
            $table->json('gambar')->nullable(); // multiple images dalam format JSON array
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0); // untuk sorting order di frontend
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
