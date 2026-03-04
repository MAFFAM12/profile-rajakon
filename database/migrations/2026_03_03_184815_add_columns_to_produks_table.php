<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->string('badge')->default('Produk')->after('nama');
            $table->text('deskripsi')->after('badge');
            $table->json('manfaat')->nullable()->after('deskripsi');
            $table->decimal('harga', 15, 2)->nullable()->after('manfaat');
            $table->json('gambar')->nullable()->after('harga');
            $table->string('slug')->unique()->after('gambar');
            $table->boolean('is_active')->default(true)->after('slug');
            $table->integer('urutan')->default(0)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn([
                'nama', 'badge', 'deskripsi', 'manfaat',
                'harga', 'gambar', 'slug', 'is_active', 'urutan'
            ]);
        });
    }
};