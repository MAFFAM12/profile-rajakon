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
        Schema::create('app_inventories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('app_name');
            $table->enum('status', ['normal', 'error', 'backup'])->default('normal');
            $table->string('link');
            $table->string('username');
            $table->string('password');
            $table->string('host_instance')->nullable();
            $table->text('description')->nullable();
            $table->uuid('primary_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_inventories');
    }
};
