<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'synology_user_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedInteger('synology_user_id')->nullable()->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'synology_user_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('synology_user_id');
            });
        }
    }
};

