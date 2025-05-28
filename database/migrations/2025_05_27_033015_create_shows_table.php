<?php
// database/migrations/xxxx_xx_xx_create_shows_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->string('rss_feed_url')->nullable(); // null for manual shows
            $table->string('language', 5)->default('en'); // ISO language code
            $table->string('author')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_fetched_at')->nullable(); // for RSS feeds
            $table->timestamps();
            
            $table->index(['is_active', 'created_at']);
            $table->index('rss_feed_url');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shows');
    }
};
