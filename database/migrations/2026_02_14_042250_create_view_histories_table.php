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
        Schema::create('view_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('story_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            
            // Should we update timestamp on duplicate or keep unique?
            // Let's just update timestamp if exists (handled in logic/upsert)
            // But for structure, unique pair makes sense if we only want "last viewed" entry per story
            // User requested "view history", arguably could be a log. 
            // V1 description says "recently viewed". 
            // Usually "Recently Viewed" is unique per story, updated_at = last view.
            $table->unique(['user_id', 'story_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_histories');
    }
};
