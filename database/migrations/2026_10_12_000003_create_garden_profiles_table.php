<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garden_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('profession', 160)->nullable();
            $table->text('biography')->nullable();
            $table->text('education')->nullable();
            $table->text('experience')->nullable();
            $table->text('achievements')->nullable();
            $table->text('interests')->nullable();
            $table->text('additional_info')->nullable();
            $table->string('featured_photo_path')->nullable();
            $table->string('status', 16)->default('draft');
            $table->timestamps();
            $table->index(['status', 'updated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garden_profiles');
    }
};
