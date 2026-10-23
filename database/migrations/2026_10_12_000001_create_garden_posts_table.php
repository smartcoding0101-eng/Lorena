<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garden_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 160);
            $table->string('slug', 190)->unique();
            $table->string('kind', 16);
            $table->string('status', 16)->default('draft');
            $table->string('category', 80)->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->timestamps();
            $table->index(['kind', 'status', 'created_at']);
            $table->index(['user_id', 'kind', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garden_posts');
    }
};
