<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->string('cover_public_id')->nullable()->after('cover_path');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('image_public_id')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('cover_public_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('image_public_id');
        });
    }
};
