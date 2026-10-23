<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garden_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 160);
            $table->text('description')->nullable();
            $table->string('media_type', 12);
            $table->string('path', 512)->unique();
            $table->string('mime_type', 80);
            $table->unsignedInteger('file_size');
            $table->timestamps();
            $table->index(['user_id', 'media_type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garden_media');
    }
};
