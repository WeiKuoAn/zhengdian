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
            $table->unsignedBigInteger('user_id');
            $table->text('name');             // 設備名稱
            $table->text('code')->nullable(); // 財產編號
            $table->text('price')->nullable();    // 單套購置金額 A
            $table->text('count')->nullable();     // 套數 B
            $table->text('life')->nullable();      // 耐用年限
            $table->text('monthly')->nullable();  // 月使用費 (自動計算)
            $table->text('investment_months')->nullable(); // 投入月數
            $table->text('total')->nullable(); 
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
