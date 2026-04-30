<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('project_milestones')) {
            return;
        }

        if (! Schema::hasColumn('project_milestones', 'linked_task_id')) {
            Schema::table('project_milestones', function (Blueprint $table) {
                $table->unsignedBigInteger('linked_task_id')->nullable();
                $table->index('linked_task_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('project_milestones') && Schema::hasColumn('project_milestones', 'linked_task_id')) {
            Schema::table('project_milestones', function (Blueprint $table) {
                $table->dropColumn('linked_task_id');
            });
        }
    }
};
