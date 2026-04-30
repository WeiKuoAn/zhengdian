<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMElement;
use DOMText;
use PhpOffice\PhpWord\SimpleType\Jc;

class SBIR2Controller extends Controller
{
    /**
     * 將一段 HTML 渲染到給定的 PhpWord Section
     */
    private function renderHtmlToSection($section, string $html): void
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8"?>' . $html);
        libxml_clear_errors();

        $body = $dom->getElementsByTagName('body')->item(0);
        if (! $body) {
            return;
        }

        foreach ($body->childNodes as $node) {
            // 處理文字節點
            if ($node instanceof DOMText) {
                $text = trim($node->textContent);
                if ($text !== '') {
                    $section->addText($text, [], ['indent' => 1100]);
                }
                continue;
            }

            // 確保僅處理元素節點
            if (! $node instanceof DOMElement) {
                continue;
            }

            switch ($node->nodeName) {
                case 'p':
                    // <p> 轉成 TextRun 並縮排
                    $run = $section->addTextRun([
                        'indent'     => 1100,
                        'spaceAfter' => 0,
                    ]);
                    $this->walkInline($run, $node);
                    $section->addTextBreak(1);
                    break;

                case 'table':
                    // 處理表格
                    $this->renderTable($section, $node);
                    $section->addTextBreak(1);
                    break;

                case 'img':
                    // 獨立 <img> 節點
                    $src = storage_path('app/public/files/' . basename($node->getAttribute('src')));
                    if (file_exists($src)) {
                        $section->addImage($src, [
                            'width'     => (int)$node->getAttribute('width')  ?: 300,
                            'height'    => (int)$node->getAttribute('height') ?: 200,
                            'alignment' => Jc::CENTER,
                        ]);
                        $section->addTextBreak(1);
                    }
                    break;

                default:
                    // 其他元素視作純文字
                    $text = trim($node->textContent);
                    if ($text !== '') {
                        $section->addText($text, [], ['indent' => 1100]);
                    }
                    break;
            }
        }
    }

    /**
     * 處理 <p> 內的各種 inline 節點：文字、粗體、斜體、換行、圖片等
     */
    private function walkInline($run, \DOMNode $node): void
    {
        foreach ($node->childNodes as $c) {
            if ($c->nodeType === XML_TEXT_NODE) {
                $txt = trim($c->textContent);
                if ($txt !== '') {
                    $run->addText($txt);
                }
                continue;
            }

            if (! $c instanceof DOMElement) {
                // 非元素當純文字
                $txt = trim($c->textContent);
                if ($txt !== '') {
                    $run->addText($txt);
                }
                continue;
            }

            switch ($c->nodeName) {
                case 'b':
                case 'strong':
                    $run->addText($c->textContent, ['bold' => true]);
                    break;

                case 'i':
                case 'em':
                    $run->addText($c->textContent, ['italic' => true]);
                    break;

                case 'br':
                    $run->addTextBreak();
                    break;

                case 'img':
                    $src = storage_path('app/public/files/' . basename($c->getAttribute('src')));
                    if (file_exists($src)) {
                        $run->addImage($src, [
                            'width'  => (int)$c->getAttribute('width')  ?: 100,
                            'height' => (int)$c->getAttribute('height') ?: 80,
                        ]);
                    }
                    break;

                default:
                    $txt = trim($c->textContent);
                    if ($txt !== '') {
                        $run->addText($txt);
                    }
                    break;
            }
        }
    }

    /**
     * 把 HTML <table> 轉為 PhpWord Table
     */
    private function renderTable($section, DOMElement $tableNode): void
    {
        $table = $section->addTable('sbirTable');
        foreach ($tableNode->getElementsByTagName('tr') as $tr) {
            $table->addRow();
            foreach ($tr->getElementsByTagName('td') as $td) {
                $cell = $table->addCell(1500);
                // 先處理 <p> 標籤內文本
                foreach ($td->getElementsByTagName('p') as $p) {
                    $txt = trim($p->textContent);
                    if ($txt !== '') {
                        $cell->addText($txt, [], ['spaceAfter' => 0]);
                    }
                }
                // 若無 <p> 再處理純文字
                if ($td->getElementsByTagName('p')->length === 0) {
                    $txt = trim($td->textContent);
                    if ($txt !== '') {
                        $cell->addText($txt, [], ['spaceAfter' => 0]);
                    }
                }
            }
        }
    }
}
