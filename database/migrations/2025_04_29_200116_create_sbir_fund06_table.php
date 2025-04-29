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
        Schema::create('sbir_fund06', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->texr('name');             // 設備名稱
            $table->texr('code')->nullable(); // 財產編號
            $table->text('price');    // 單套購置金額 A
            $table->text('count');     // 套數 B
            $table->text('life');      // 耐用年限
            $table->text('monthly');  // 月使用費 (自動計算)
            $table->text('investment_months'); // 投入月數
            $table->text('total'); // 使用費用概算 (自動計算)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbir_fund06');
    }
};
