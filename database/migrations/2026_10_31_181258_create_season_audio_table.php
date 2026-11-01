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
        Schema::create('season_audio', function (Blueprint $table) {
            $table->id();
            $table->string('season', 32); // spring, rain, summer, autumn, winter, stars, bubbles, clear
            $table->string('title', 160);
            $table->string('file_path', 512);
            $table->string('original_name', 255)->nullable();
            $table->string('mime_type', 80)->default('audio/mpeg');
            $table->unsignedInteger('file_size')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['season', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('season_audio');
    }
};
