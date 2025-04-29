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
        Schema::create('sbir_fund10', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id'); // 所屬計畫
            $table->unsignedBigInteger('user_id'); // 所屬計畫
            $table->text('tax_id')->nullable();                 // 合作單位統編
            $table->text('company_name')->nullable();           // 合作單位
            $table->text('content')->nullable();                // 內容
            $table->text('amount')->nullable();         // 合作金額
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbir_fund10');
    }
};
