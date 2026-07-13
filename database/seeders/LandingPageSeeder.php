<?php

namespace Database\Seeders;

use App\Models\LandingBrandClient;
use App\Models\LandingContentItem;
use App\Models\LandingIndustryCategory;
use App\Models\LandingSetting;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        if (LandingSetting::query()->exists()) {
            return;
        }

        LandingSetting::setMany([
            'meta_title' => '錚典科技國際有限公司｜政府補助顧問・AI 數位轉型・智慧升級規劃',
            'meta_description' => '錚典科技以企業營運診斷為起點，整合政府補助申請、AI 數位轉型與智慧升級，250+ 企業輔導實績、6 億+ 過案金額、跨產業整合顧問。',
            'hero_eyebrow' => 'COMPANY PROFILE｜ZHENG DIAN Technology Co., Ltd.',
            'hero_title' => "從補助申請到數位轉型導入\n協助企業找到可落地的成長路徑",
            'hero_tagline' => '政府補助顧問 ｜ AI 數位轉型 ｜ 智慧升級規劃',
            'hero_lead' => '錚典科技以企業營運診斷為起點，協助客戶盤點政府資源、設計可落地的數位轉型與 AI 方案，並整合申請、執行、查核與結案流程，將補助計畫從「想法」落到「可被委員理解、可被期中期末驗收」的執行設計。',
            'hero_btn_primary' => '預約補助健檢',
            'hero_btn_secondary' => '查看 500+ 合作案例',
            'services_eyebrow' => 'SERVICE PORTFOLIO',
            'services_title' => '服務架構｜以「補助 × 顧問 × AI 導入」整合企業升級路徑',
            'services_subtitle' => '錚典將四大顧問能力整合為一條龍服務，協助企業依自身階段與需求，找到最適合的搭配方案。',
            'workflow_eyebrow' => 'SUBSIDY CONSULTING WORKFLOW',
            'workflow_title' => '補助顧問六階段流程',
            'workflow_subtitle' => '一條龍服務：資料蒐集 → 申請送件 → 審查 → 核定簽約 → 期中管理 → 期末結案',
            'workflow_footer' => '🔗 錚典的角色：降低客戶理解門檻、縮短資料整備時間、提高計畫敘事與查核可行性',
            'themes_eyebrow' => 'GRANT THEMES',
            'themes_title' => '可延伸的補助主題',
            'themes_subtitle' => '可依產業別、公司規模、場域成熟度與送件時程，組合最適申請路徑。',
            'scenarios_eyebrow' => 'CLIENT SCENARIOS',
            'scenarios_title' => '典型服務場景',
            'scenarios_subtitle' => '跨產業整合顧問經驗，針對各種營運場景提供客製化解決方案。',
            'cases_eyebrow' => 'CASE CATEGORIES',
            'cases_title' => '六大產業案例｜500+ 合作客戶 Brand Wall 2026',
            'cases_subtitle' => '跨食品餐飲、零售服務、旅宿觀光、製造研發、農產生技與海外市場拓展，錚典提供跨產業整合顧問經驗。',
            'cases_disclaimer' => '※ 以上為錚典科技曾服務之代表性客戶，所有案例經客戶授權後對外呈現；本頁僅作合作呈現使用，並非過案保證或結果擔保。',
            'academic_eyebrow' => 'GLOBAL TALENT & ACADEMIC RESOURCES',
            'academic_title' => '立足本土，走向國際｜國際資源與產學能量',
            'academic_subtitle' => "自 2017 年起參與工研院、數位發展部、AIT 美國在台協會相關產學計畫；\n2019-2024 連續 6 年參與 DIGI+Talent 跨域數位人才加速躍升計畫，曾獲「數位新星大賞特選」殊榮。",
            'academic_note' => '🏛️ 合作機關：工研院、數位發展部、AIT 美國在台協會相關計畫｜ DIGI+Talent 跨域數位人才加速躍升計畫 6 年（2019-2024）｜曾獲「數位新星大賞特選」殊榮',
            'why_eyebrow' => 'WHY ZHENG DIAN',
            'why_title' => '為什麼選擇錚典',
            'why_subtitle' => '四個關鍵能力：懂補助、懂營運、懂 AI 與數位、懂落地。',
            'cta_title' => "讓企業升級，\n從一份可執行的計畫開始",
            'cta_text' => "錚典科技可協助企業進行初步盤點，評估適合的政府補助資源、AI 導入方向與升級策略。\n30 分鐘免費線上諮詢，無需事前準備。",
            'contact_name' => '鍾泳畇 Zara',
            'contact_phone' => '0906-063016',
            'contact_tel' => '04-2221-9965',
            'contact_email' => 'sara101708@gmail.com',
            'contact_line_url' => '#',
            'footer_desc' => '以企業營運診斷為起點，整合政府補助申請、AI 數位轉型與智慧升級規劃，協助企業找到可落地的成長路徑。',
        ]);

        $this->seedContentItems();
        $this->seedIndustryCategories();
    }

    protected function seedContentItems(): void
    {
        $items = [
            ['stat', '250', '企業輔導實績', '製造、食品、零售、流通、服務業', null, '+', 1],
            ['stat', '6 億', '合計過案金額', '累積政府補助、專案申請與轉型成果', null, '+', 2],
            ['stat', '90', '媒合方案', '補助、數位工具、系統與合作資源', null, '+', 3],
            ['stat', '500', '合作客戶', '六大產業跨域整合顧問經驗', null, '+', 4],
            ['service', '政府補助規劃', 'Subsidy Planning', "補助地圖與資格盤點\n申請主題設計\n計畫書與簡報產出\n期中／期末查核協作", '$', null, 1],
            ['service', '企業整合顧問', 'Integrated Consulting', "商業模式建立\n策略目標規劃\n經營診斷分析\n事業體與商模整合", 'C', null, 2],
            ['service', 'AI 數位轉型', 'AI Transformation', "數位發展方向\n營運流程優化\n數據／AI 工具導入\n儀表板與管理機制", 'AI', null, 3],
            ['service', '品牌與行銷升級', 'Brand & Marketing', "品牌定位與策略\nO2O 營運架構\n活動／社群行銷\n平台規劃與建置", 'B', null, 4],
            ['process', '資料盤點', null, '公司條件、營運資料、財務與場域資料', null, null, 1],
            ['process', '計畫適配', null, '補助類型、申請資格、經費上限與送件時程', null, null, 2],
            ['process', '主題設計', null, 'AI、節能、研發、數位工具與示範效益', null, null, 3],
            ['process', '文件產出', null, '計畫書、簡報、預算表、附件', null, null, 4],
            ['process', '審查陪跑', null, '簡報演練、委員 Q&A、修正補件', null, null, 5],
            ['process', '執行管理', null, '期中、期末、驗收佐證與結案資料', null, null, 6],
            ['theme', 'AI 營運代理', null, '需求預測、補貨建議、營運決策看板', null, null, 1],
            ['theme', 'AI 能源管理', null, '用電監測、節能診斷、設備維護預警', null, null, 2],
            ['theme', '研發轉型', null, '因應關稅衝擊或提升競爭力、產品/製程研發升級', null, null, 3],
            ['theme', '智慧減碳', null, '智慧設備、節能服務、低碳營運模式', null, null, 4],
            ['theme', '多店／供應鏈整合', null, '總部、門市、供應商資料串接與擴散', null, null, 5],
            ['theme', '品牌與平台升級', null, 'B2B/B2C 平台、會員/CRM、O2O 導流', null, null, 6],
            ['scenario', '製造／食品加工', null, 'AI 製程優化、品質預警、產線數據回流、節能減碳', null, null, 1],
            ['scenario', '零售／餐飲連鎖', null, '多店升級、B2B 訂貨、需求預測、會員與 CRM', null, null, 2],
            ['scenario', '旅宿／觀光平台', null, 'AI 客服、智慧推薦、動態價格、國際客數據分析', null, null, 3],
            ['scenario', '商場／集合式場域', null, 'AI 能源管理、用電診斷、設備維護、節能績效量測', null, null, 4],
            ['scenario', '品牌／電商平台', null, '平台規劃、O2O 營運、行銷策略、轉換數據分析', null, null, 5],
            ['scenario', '研發／新產品', null, 'SBIR / CITD / TIIP / 淬鍊計劃、技術驗證與商業化', null, null, 6],
            ['why', '懂補助', '補助資源 ×', '熟悉政府計畫邏輯，將企業需求轉譯成委員可理解的計畫語言。', null, null, 1],
            ['why', '懂營運', 'AI 導入 ×', '不是單純寫文件，而是從現場痛點、流程與資料可得性設計方案。', null, null, 2],
            ['why', '懂 AI 與數位', '企業升級', '將 AI、數據、系統工具與查核驗收連成可執行專案。', null, null, 3],
            ['why', '懂落地', '期中期末驗收', '重視期中期末資料、KPI 與佐證方式，降低執行風險。', null, null, 4],
            ['academic_stat', '9+', '年｜產學合作', '自 2017 年起', null, null, 1],
            ['academic_stat', '24+', '所｜合作大專院校', '頂大／科大／私校', null, null, 2],
            ['academic_stat', '21+', '國｜學生團隊', '橫跨亞、歐、美、非', null, null, 3],
            ['academic_stat', '100+', '人｜培育跨域人才', '含國際研習生', null, null, 4],
        ];

        foreach ($items as [$type, $title, $subtitle, $body, $icon, $extra, $seq]) {
            LandingContentItem::create([
                'type' => $type,
                'title' => $title,
                'subtitle' => $subtitle,
                'body' => $body,
                'icon' => $icon,
                'extra' => $extra,
                'seq' => $seq,
                'status' => 'up',
            ]);
        }

        $countries = ['🇹🇼 台灣', '🇭🇰 香港', '🇮🇩 印尼', '🇲🇾 馬來西亞', '🇰🇭 柬埔寨', '🇹🇭 泰國', '🇻🇳 越南', '🇲🇲 緬甸', '🇱🇦 寮國', '🇵🇭 菲律賓', '🇸🇬 新加坡', '🇲🇳 蒙古', '🇮🇳 印度', '🇯🇵 日本', '🇰🇷 韓國', '🇭🇹 海地', '🇲🇽 墨西哥', '🇺🇸 美國', '🇪🇸 西班牙', '🇱🇻 拉脫維亞', '🇷🇺 俄羅斯'];
        foreach ($countries as $i => $name) {
            LandingContentItem::create(['type' => 'country', 'title' => $name, 'seq' => $i + 1, 'status' => 'up']);
        }

        $universities = ['國立\n臺灣大學', '國立\n清華大學', '國立陽明\n交通大學', '國立\n成功大學', '國立\n政治大學', '國立\n中興大學', '臺北\n科技大學', '臺灣\n科技大學', '高雄\n科技大學', '雲林\n科技大學', '屏東\n科技大學', '彰化\n師範大學', '國立\n中正大學', '國立\n中山大學', '國立暨南\n國際大學', '國立\n高雄大學', '逢甲大學', '中原大學', '東海大學', '淡江大學', '世新大學', '輔仁大學', '亞洲大學', '靜宜大學'];
        foreach ($universities as $i => $name) {
            LandingContentItem::create(['type' => 'university', 'title' => $name, 'seq' => $i + 1, 'status' => 'up']);
        }
    }

    protected function seedIndustryCategories(): void
    {
        $categories = [
            [
                'code' => 'CATEGORY 01',
                'name' => '食品餐飲 / 製造',
                'description' => '食品製造、伴手禮、餐飲連鎖、烘焙與飲品；協助補助申請、智慧消費、AI 點餐/POS-ERP 整合、品牌升級。',
                'grid_columns' => 6,
                'brands' => ['上海鄉村', '中台太陽堂', '丸文調理食品', '元氣先生', '兵兵有禮', '博雅齋紅烏龍', '卷卷', '台灣第一味', '向記食品', '喜洋洋餐飲', '喫茶小舖', '大漁壽司', '大瑪南洋', '大碗公冰品', '寶泉糕餅', '寶珍香', '岳佳·櫻島家', 'Schokolake', '彩碗', '徐泰山沙茶', '日日裝茶', '曾記麻糬', '杏花村商行', '林三茶', '榮玉食品', '歐巴饅頭', '歡樂派', '沙茶懂娘', 'PokéPoké 波奇', '澎沛黑白木耳飲', '熱浪島南洋蔬食', '狸小路千層蛋糕', '粕味', '義昌食品', '臻狀元', '華冠乳品', '貳百加', '連城記', '錦松', '陳家麻糬', '陳石城', '風間燒肉', '麥仕佳烘焙'],
            ],
            [
                'code' => 'CATEGORY 02',
                'name' => '零售服務 / 資訊系統',
                'description' => '零售門市、批發、便利通路、數據驅動、AI 客服、會員整合、智慧供應鏈進化。',
                'grid_columns' => 6,
                'brands' => ['COCOMART', '便利帶', '普世玩', '數匯智控', '達鈦科技', '聯成電腦', '國興資訊', 'Ariel Premium'],
            ],
            [
                'code' => 'CATEGORY 03',
                'name' => '旅宿觀光',
                'description' => "旅館、文創園區；數位行銷、訂房系統、客戶數據中台與 AI 收益管理。\nFOCUS｜島宇居旅宿聯盟 CYU YU SHENG Luxury Hotel Group：跨場域旅宿聯盟｜AI 收益與訂房中台",
                'grid_columns' => 3,
                'brands' => ['島宇居旅宿聯盟', '巨宇勝', '勤牧'],
            ],
            [
                'code' => 'CATEGORY 04',
                'name' => '製造研發',
                'description' => '食品加工、塑膠製品、機械、五金、紙器；數位轉型、傳承接班、製程優化與系統導入。',
                'grid_columns' => 5,
                'brands' => ['三耑實業', '嘉駿工業', '大煒塑膠', '寶泰科技', '廠茂紙器', '旭光箔膜', '樺正', '祥盟', '新楠星', '曜陞綠能'],
            ],
            [
                'code' => 'CATEGORY 05',
                'name' => '農產生技',
                'description' => '生鮮食品、保健品、研發、通路擴展、數位轉型、ESG 永續發展。',
                'grid_columns' => 7,
                'brands' => ['太陽生鮮', '太陽農場', '展鮮', '芯鮮果', '洋果', '荷華達康', '一點利'],
            ],
            [
                'code' => 'CATEGORY 06',
                'name' => '海外市場',
                'description' => "跨境品牌、海外通路布建、雙語素材、展會與通路媒合計畫。\n跨境品牌推進軸：品牌定位 → 雙語素材 → 展會/通路媒合 → 海外擴點",
                'grid_columns' => 4,
                'brands' => ['PokéPoké 波奇', '喫茶小舖', '台灣第一味', '大碗公冰品'],
            ],
        ];

        foreach ($categories as $index => $cat) {
            $category = LandingIndustryCategory::create([
                'code' => $cat['code'],
                'name' => $cat['name'],
                'description' => $cat['description'],
                'grid_columns' => $cat['grid_columns'],
                'seq' => $index + 1,
                'status' => 'up',
            ]);

            foreach ($cat['brands'] as $brandIndex => $brandName) {
                LandingBrandClient::create([
                    'category_id' => $category->id,
                    'name' => $brandName,
                    'seq' => $brandIndex + 1,
                    'status' => 'up',
                ]);
            }
        }
    }
}
