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
        Schema::create('friend_dedications', function (Blueprint $table) {
            $table->id();
            $table->string('author_name', 100);
            $table->text('message');
            $table->string('flower_badge', 30)->default('🌸');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_dedications');
    }
};
