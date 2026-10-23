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
        Schema::create('garden_notes', function (Blueprint $table) {
            $table->id();
            $table->string('screen_key')->index(); // 'inicio', 'sultana-plataformas', 'lectura', 'jardines-liria', etc.
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('author_name')->default('Carla Lorena');
            $table->string('title')->nullable();
            $table->text('content');
            $table->string('mood')->default('love'); // love, dream, memory, gratitude, secret
            $table->string('image_path')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garden_notes');
    }
};
