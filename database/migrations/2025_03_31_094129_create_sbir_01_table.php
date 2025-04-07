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
        Schema::create('sbir_01', function (Blueprint $table) {
            $table->id();

            $table->string('plan_name');          // 計畫名稱
            $table->string('attribute');          // 屬性
            $table->string('stage');              // 階段
            $table->string('domain');             // 領域
            $table->string('feature')->nullable(); // 計畫特色
            $table->string('applicant');          // 申請對象

            $table->date('start_date');           // 計畫起日 (ex: 2025-04-21)
            $table->date('end_date');             // 計畫迄日 (ex: 2026-03-31)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbir_01');
    }
};
