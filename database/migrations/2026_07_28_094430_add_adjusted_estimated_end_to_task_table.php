<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("SET SESSION sql_mode = ''");

        if (Schema::hasTable('task') && ! Schema::hasColumn('task', 'adjusted_estimated_end')) {
            DB::statement('ALTER TABLE `task` ADD `adjusted_estimated_end` DATETIME NULL DEFAULT NULL AFTER `estimated_end`');
        }

        if (! Schema::hasTable('task_estimated_end_adjustments')) {
            Schema::create('task_estimated_end_adjustments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('task_id')->index();
                $table->dateTime('adjusted_estimated_end');
                $table->dateTime('previous_adjusted_estimated_end')->nullable();
                $table->text('note')->nullable();
                $table->unsignedBigInteger('created_by')->nullable()->index();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('task_estimated_end_adjustments');

        if (Schema::hasTable('task') && Schema::hasColumn('task', 'adjusted_estimated_end')) {
            DB::statement("SET SESSION sql_mode = ''");
            DB::statement('ALTER TABLE `task` DROP COLUMN `adjusted_estimated_end`');
        }
    }
};
