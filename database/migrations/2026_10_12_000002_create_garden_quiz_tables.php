<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garden_quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->json('answer_hashes');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['is_active', 'id']);
        });

        Schema::create('garden_quiz_sessions', function (Blueprint $table) {
            $table->char('token_hash', 64)->primary();
            $table->json('questions_snapshot');
            $table->unsignedTinyInteger('current_index')->default(0);
            $table->timestamp('expires_at')->index();
            $table->timestamp('passed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('garden_quiz_settings', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->string('reward_image_path')->nullable();
            $table->timestamp('reward_authorized_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garden_quiz_settings');
        Schema::dropIfExists('garden_quiz_sessions');
        Schema::dropIfExists('garden_quiz_questions');
    }
};
