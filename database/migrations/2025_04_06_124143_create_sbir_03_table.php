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
        Schema::create('sbir_03', function (Blueprint $table) {
            $table->id();
    
            // 文字描述區
            $table->text('plan_summary')->nullable();              // 一、計畫內容摘要
            $table->text('innovation_focus')->nullable();          // 二、計畫創新重點
            $table->text('execution_advantage')->nullable();       // 三、執行優勢
    
            // 預期效益（數值欄位）
            $table->integer('benefit_output_value')->nullable();       // 1. 增加產值(千元)
            $table->integer('benefit_new_products')->nullable();       // 2. 產出新產品或服務
            $table->integer('benefit_derived_products')->nullable();   // 3. 衍生商品或服務
            $table->integer('benefit_rnd_cost')->nullable();           // 4. 投入研發費用(千元)
            $table->integer('benefit_investment')->nullable();         // 5. 促成投資額(千元)
            $table->integer('benefit_cost_reduction')->nullable();     // 6. 降低成本(千元)
            $table->integer('benefit_jobs_created')->nullable();       // 7. 增加就業人數(人)
            $table->integer('benefit_new_companies')->nullable();      // 8. 成立新公司(家)
            $table->integer('benefit_patents')->nullable();            // 9. 發明專利(件)
            $table->integer('benefit_new_patents')->nullable();        // 10. 新型/新式樣專利(件)
    
            // 關聯欄位
            $table->unsignedBigInteger('project_id')->nullable()->index(); // 可加外鍵關聯
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbir_03');
    }
};
