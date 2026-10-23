<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('album_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('album_id');
            $table->string('path', 512)->unique();
            $table->string('title', 120);
            $table->text('description')->nullable();
            $table->string('mime_type', 40);
            $table->unsignedInteger('file_size');
            $table->boolean('is_favorite')->default(false);
            $table->timestamps();
            $table->foreign(['album_id', 'user_id'])
                ->references(['id', 'user_id'])
                ->on('albums')
                ->cascadeOnDelete();
            $table->index(['user_id', 'is_favorite']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('album_photos');
    }
};
