<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tagline', 140)->nullable()->after('role');
            $table->text('bio')->nullable()->after('tagline');
            $table->string('avatar_path')->nullable()->after('bio');
            $table->string('linkedin_url')->nullable()->after('avatar_path');
            $table->string('github_url')->nullable()->after('linkedin_url');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tagline',
                'bio',
                'avatar_path',
                'linkedin_url',
                'github_url',
            ]);
        });
    }
};

