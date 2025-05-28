<?php
// database/migrations/xxxx_xx_xx_create_comments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('episode_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->tinyInteger('rating')->nullable(); // 1-5 stars
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
            
            $table->index(['episode_id', 'created_at']);
            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
