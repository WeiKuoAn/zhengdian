<?php

namespace App\Services;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\IOFactory;

class WordExporter
{
    /**
     * 過濾 HTML 內容，保留排版，移除 <img>
     */
    public function cleanHtmlContent(string $html): string
{
    // 1. 移除所有圖片
    $html = preg_replace('/<img[^>]*>/i', '', $html);

    // 2. 可選：移除 <script>, <style>
    $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);
    $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $html);

    // 3. 可選：修補某些孤立標籤
    $html = trim($html);

    return $html;
}

    
    




    /**
     * 將多組 HTML 區塊插入 Word 檔案，並儲存
     *
     * @param array $sections [
     *     ['title' => '一、研發動機', 'html' => '<ul><li>...</li></ul>'],
     *     ['title' => '二、競爭力分析', 'html' => '<p>...</p>'],
     * ]
     * @return string 儲存後檔案完整路徑
     */
    public function generateDocFromHtmlArray(array $sections): string
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        foreach ($sections as $block) {
            if (!empty($block['title'])) {
                $section->addText($block['title'], ['bold' => true, 'size' => 14]);
            }

            if (!empty($block['html'])) {
                Html::addHtml($section, $block['html'], false, false);
                $section->addTextBreak(); // 加點空白行
            }
        }

        $filename = 'word_export_' . now()->format('Ymd_His') . '.docx';
        $fullPath = storage_path('app/temp/' . $filename);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($fullPath);

        return $fullPath;
    }
}
