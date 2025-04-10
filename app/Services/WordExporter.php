<?php

namespace App\Services;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Font;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\Shared\Html;

class WordExporter
{
    protected PhpWord $phpWord;
    protected $section;

    public function __construct()
    {
        $this->phpWord = new PhpWord();
        $this->section = $this->phpWord->addSection();
    }

    public static function fromHtml(string $html): self
    {
        $exporter = new self();
        $exporter->parseHtml($html);
        return $exporter;
    }

    public function download(string $filename = 'export.docx')
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'word') . '.docx';
        $writer = IOFactory::createWriter($this->phpWord, 'Word2007');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    protected function parseHtml(string $html)
    {
        libxml_use_internal_errors(true);
        $html = preg_replace('/<img(.*?)>/', '<img$1 />', $html);
        $wrappedHtml = '<!DOCTYPE html><html><body>' . $html . '</body></html>';

        $doc = new \DOMDocument();
        $doc->loadHTML(mb_convert_encoding($wrappedHtml, 'HTML-ENTITIES', 'UTF-8'));
        $body = $doc->getElementsByTagName('body')->item(0);

        if (!$body) return;

        foreach ($body->childNodes as $node) {
            $this->parseNode($node);
        }
    }

    protected function parseNode($node)
    {
        if ($node->nodeType === XML_TEXT_NODE) {
            $this->section->addText($node->nodeValue);
        } elseif ($node->nodeType === XML_ELEMENT_NODE) {
            switch (strtolower($node->nodeName)) {
                case 'p':
                    $this->section->addText($this->getNodeText($node));
                    break;
                case 'h1':
                    $this->section->addText($this->getNodeText($node), ['bold' => true, 'size' => 20]);
                    break;
                case 'h2':
                    $this->section->addText($this->getNodeText($node), ['bold' => true, 'size' => 16]);
                    break;
                case 'strong':
                    $this->section->addText($this->getNodeText($node), ['bold' => true]);
                    break;
                case 'img':
                    $src = $node->getAttribute('src');
                    if (filter_var($src, FILTER_VALIDATE_URL)) {
                        $this->addImageFromUrl($src);
                    }
                    break;
                default:
                    $this->section->addText($this->getNodeText($node));
            }
        }
    }

    protected function getNodeText($node)
    {
        return $node->textContent ?? '';
    }

    protected function addImageFromUrl(string $url)
    {
        try {
            // 用 cURL 下載圖片（更穩）
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $imgData = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            curl_close($ch);

            if ($httpCode !== 200 || !Str::startsWith($contentType, 'image/')) {
                $this->section->addText('[圖片下載失敗或格式錯誤]');
                return;
            }

            $ext = match ($contentType) {
                'image/png' => 'png',
                'image/jpeg', 'image/jpg' => 'jpg',
                'image/gif' => 'gif',
                default => 'jpg',
            };

            $tempImg = tempnam(sys_get_temp_dir(), 'img') . '.' . $ext;
            file_put_contents($tempImg, $imgData);

            $this->section->addImage($tempImg, [
                'width' => 400, // 可調整
            ]);
        } catch (\Exception $e) {
            $this->section->addText('[圖片處理錯誤]');
        }
    }
    public function exportHtmlToWord($html, $filename = 'document.docx')
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        Html::addHtml($section, $html, false, false);

        $tempStream = fopen('php://temp', 'r+');
        IOFactory::createWriter($phpWord, 'Word2007')->save($tempStream);
        rewind($tempStream);

        return response()->streamDownload(function () use ($tempStream) {
            fpassthru($tempStream);
        }, $filename);
    }

    public function cleanHtmlContent($html)
{
    libxml_use_internal_errors(true);

    // 強制自閉 <img>
    $html = preg_replace('/<img(.*?)>/', '<img$1 />', $html);

    // 包裝成合法 HTML 結構
    $wrappedHtml = '<!DOCTYPE html><html><body>' . $html . '</body></html>';

    $doc = new \DOMDocument();

    try {
        $doc->loadHTML(mb_convert_encoding($wrappedHtml, 'HTML-ENTITIES', 'UTF-8'));
    } catch (\Throwable $e) {
        libxml_clear_errors();
        return strip_tags($html); // fallback
    }

    $body = $doc->getElementsByTagName('body')->item(0);
    if (!$body || !$body->hasChildNodes()) {
        libxml_clear_errors();
        return strip_tags($html); // fallback again
    }

    $innerHTML = '';
    foreach ($body->childNodes as $child) {
        if ($child instanceof \DOMNode) {
            $innerHTML .= $doc->saveHTML($child);
        }
    }

    libxml_clear_errors();
    return $innerHTML;
}
}
