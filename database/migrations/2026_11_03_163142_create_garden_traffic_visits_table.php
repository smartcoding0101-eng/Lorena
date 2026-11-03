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
        Schema::create('garden_traffic_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('visitor_uuid', 64)->index();
            $table->string('screen', 50)->default('inicio')->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('device', 30)->default('Escritorio');
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('referer', 255)->nullable();
            $table->text('user_agent')->nullable();
            $table->unsignedInteger('duration_seconds')->default(0);
            $table->timestamp('last_seen_at')->nullable()->index();
            $table->timestamps();

            $table->index(['created_at', 'screen']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garden_traffic_visits');
    }
};
