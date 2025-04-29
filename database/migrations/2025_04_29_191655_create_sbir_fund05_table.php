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
        Schema::create('sbir_fund05', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id'); // 對應專案
            $table->Integer('project_id'); // 對應專案
            $table->text('equipment_name')->nullable();;         // 設備名稱
            $table->text('asset_number')->nullable();;           // 財產編號
            $table->text('purchase_amount')->nullable();;       // 單套購置金額
            $table->text('purchase_date')->nullable();;          // 購入日期(年/月)
            $table->text('book_value')->nullable();;            // 帳面價值 A
            $table->text('set_count')->nullable();;             // 套數 B
            $table->text('remaining_years')->nullable();;       // 剩餘使用年限
            $table->text('investment_months')->nullable();;     // 投入月數
            $table->timestamps();
        
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbir_fund05');
    }
};
