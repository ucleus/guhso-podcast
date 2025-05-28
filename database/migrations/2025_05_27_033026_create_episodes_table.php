<?php
// database/migrations/xxxx_xx_xx_create_episodes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('audio_url'); // URL or file path
            $table->integer('duration')->nullable(); // seconds
            $table->timestamp('published_at')->nullable();
            $table->string('guid')->nullable(); // for RSS episodes
            $table->string('thumbnail_url')->nullable();
            $table->boolean('is_manual')->default(false); // true for manually added
            $table->string('episode_number')->nullable();
            $table->string('season_number')->nullable();
            $table->bigInteger('file_size')->nullable(); // bytes
            $table->string('mime_type')->default('audio/mpeg');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            
            $table->index(['show_id', 'published_at']);
            $table->index(['is_published', 'published_at']);
            $table->unique('guid'); // ensure RSS GUID uniqueness
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
