<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('role_badge');
            $table->string('category')->default('children'); // carla, adrian, ody, children
            $table->string('avatar_icon')->default('💎');
            $table->text('bio')->nullable();
            $table->string('special_date')->nullable();
            $table->string('favorite_quote')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('theme_color')->default('sapphire');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('family_memories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->nullable()->constrained('family_members')->nullOnDelete();
            $table->string('category')->default('todos'); // todos, carla, adrian, ody, children
            $table->string('title');
            $table->text('story')->nullable();
            $table->string('memory_date')->nullable();
            $table->string('emotion_tag')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_memories');
        Schema::dropIfExists('family_members');
    }
};

