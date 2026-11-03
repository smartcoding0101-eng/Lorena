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
        Schema::create('garden_gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('category')->default('foto'); // foto, video, familia, amigos, especiales
            $table->string('pill')->nullable(); // e.g. "Colección Carla", "Serenidad"
            $table->string('tag_label')->nullable(); // e.g. "FOTOGRAFÍA BOTÁNICA"
            $table->text('quote')->nullable(); // e.g. «Para recordarte lo bonito que es florecer despacio...»
            $table->string('image_path');
            $table->string('video_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garden_gallery_items');
    }
};

