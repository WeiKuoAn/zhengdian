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
        Schema::create('sbir_fund07', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 所屬計畫
            $table->unsignedBigInteger('project_id');
            $table->text('name')->nullable();                  // 設備名稱
            $table->text('code')->nullable();      // 財產編號
            $table->text('unit_price')->nullable();    // 單套原購置金額
            $table->text('count')->nullable();          // 套數
            $table->text('total')->nullable();         // 維護費用概算
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbir_fund07');
    }
};
