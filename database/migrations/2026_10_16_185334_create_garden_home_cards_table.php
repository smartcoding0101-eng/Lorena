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
        Schema::create('garden_home_cards', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('subtitle', 60)->nullable();
            $table->string('emblem_icon', 30)->default('🌸 ❦');
            $table->text('description');
            $table->string('quote', 200)->nullable();
            $table->string('target_screen', 60)->default('galeria');
            $table->string('style_variant', 60)->default('space-card-large');
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
        Schema::dropIfExists('garden_home_cards');
    }
};
