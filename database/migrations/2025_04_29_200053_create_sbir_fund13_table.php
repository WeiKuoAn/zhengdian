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
        Schema::create('sbir_fund13', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');
            $table->text('purpose')->nullable();         // 出差事由
            $table->text('location')->nullable();        // 地點
            $table->text('days')->nullable();           // 天數
            $table->text('people')->nullable();         // 人次
            $table->text('airfare')->nullable(); // 機票
            $table->text('transport')->nullable(); // 車資
            $table->text('accommodation')->nullable(); // 住宿費
            $table->text('meals')->nullable();   // 膳雜費
            $table->text('others')->nullable();  // 其他
            $table->text('total')->nullable();   // 全程費用概算
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbir_fund13');
    }
};
