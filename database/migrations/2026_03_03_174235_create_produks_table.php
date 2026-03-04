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
            $table->string('badge')->default('Produk'); // label badge merah
            $table->text('deskripsi');
            $table->text('manfaat')->nullable(); // simpan sebagai JSON atau text
            $table->decimal('harga', 15, 2)->nullable();
            $table->json('gambar')->nullable(); // multiple images
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
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
