<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 統編查詢（經濟部商工行政資料開放平臺）
    |--------------------------------------------------------------------------
    |
    | 公司登記基本資料-應用一、商業登記基本資料-應用三。
    | 實測可匿名查詢（免驗證碼）；若遇限流請加大 delay。
    |
    */

    'base_url' => env('GCIS_API_BASE_URL', 'https://data.gcis.nat.gov.tw/od/data/api'),

    'timeout' => (int) env('GCIS_API_TIMEOUT', 20),

    /** 每次 API 呼叫間隔（微秒），預設 0.3 秒 */
    'delay_microseconds' => (int) env('GCIS_API_DELAY_US', 300000),

    'endpoints' => [
        'company_basic' => '5F64D864-61CB-4D0D-8AD9-492047CC1EA6',
        'business_basic' => '426D5542-5F05-43EB-83F9-F1300F14E1F1',
    ],

    /** Excel 批次最多筆數（避免一次打爆政府 API） */
    'batch_max_rows' => (int) env('GCIS_BATCH_MAX_ROWS', 200),
];
