<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('garden_media', function (Blueprint $table) {
            $table->string('source_type', 24)->default('upload')->after('media_type');
            $table->text('source_url')->nullable()->after('source_type');
            $table->string('path', 512)->nullable()->change();
            $table->string('mime_type', 80)->nullable()->change();
            $table->unsignedInteger('file_size')->nullable()->change();
        });
    }

    public function down(): void
    {
        if (DB::table('garden_media')->where('source_type', '!=', 'upload')->exists()) {
            throw new \RuntimeException('Retira los enlaces guardados antes de revertir esta migración.');
        }

        Schema::table('garden_media', function (Blueprint $table) {
            $table->dropColumn(['source_url', 'source_type']);
            $table->string('path', 512)->nullable(false)->change();
            $table->string('mime_type', 80)->nullable(false)->change();
            $table->unsignedInteger('file_size')->nullable(false)->change();
        });
    }
};
