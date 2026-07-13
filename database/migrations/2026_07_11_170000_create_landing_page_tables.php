<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('landing_settings')) {
            Schema::create('landing_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('landing_content_items')) {
            Schema::create('landing_content_items', function (Blueprint $table) {
                $table->id();
                $table->string('type', 50);
                $table->string('title')->nullable();
                $table->string('subtitle')->nullable();
                $table->text('body')->nullable();
                $table->string('icon', 20)->nullable();
                $table->string('extra', 500)->nullable();
                $table->unsignedInteger('seq')->default(0);
                $table->string('status', 10)->default('up');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('landing_industry_categories')) {
            Schema::create('landing_industry_categories', function (Blueprint $table) {
                $table->id();
                $table->string('code', 30)->nullable();
                $table->string('name');
                $table->text('description')->nullable();
                $table->unsignedTinyInteger('grid_columns')->default(6);
                $table->unsignedInteger('seq')->default(0);
                $table->string('status', 10)->default('up');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('landing_brand_clients')) {
            Schema::create('landing_brand_clients', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('category_id');
                $table->string('name');
                $table->string('logo_path')->nullable();
                $table->unsignedInteger('seq')->default(0);
                $table->string('status', 10)->default('up');
                $table->timestamps();

                $table->index(['category_id', 'status', 'seq']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_brand_clients');
        Schema::dropIfExists('landing_industry_categories');
        Schema::dropIfExists('landing_content_items');
        Schema::dropIfExists('landing_settings');
    }
};
