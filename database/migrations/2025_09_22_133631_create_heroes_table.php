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
        Schema::create('heroes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('heading');
            $table->string('sub_heading')->nullable();
            $table->string('cta_link')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('hero_image')->nullable();
            $table->json('images')->nullable(); // For multiple image uploads
            $table->string('images_display_type')->default('slide'); // slide or card
            $table->boolean('status')->default(true); // active/inactive
            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
