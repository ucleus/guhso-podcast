<?php
// database/migrations/xxxx_xx_xx_add_role_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin'])->default('user')->after('email_verified_at');
            $table->string('language_pref', 5)->default('en')->after('role');
            $table->string('avatar_url')->nullable()->after('language_pref');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'language_pref', 'avatar_url']);
        });
    }
};
