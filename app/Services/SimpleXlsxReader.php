<?php

namespace App\Services;

use RuntimeException;
use ZipArchive;

/** 讀取第一個工作表（足夠應付匯入範本）。 */
final class SimpleXlsxReader
{
    /**
     * @return list<list<string>>
     */
    public static function readFirstSheet(string $path): array
    {
        $zip = new ZipArchive();
        if ($zip->open($path) !== true) {
            throw new RuntimeException('無法開啟 Excel 檔案');
        }

        try {
            $sharedStrings = self::readSharedStrings($zip);
            $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
            if ($sheetXml === false) {
                throw new RuntimeException('找不到工作表 sheet1');
            }

            return self::parseSheetRows($sheetXml, $sharedStrings);
        } finally {
            $zip->close();
        }
    }

    /** @return list<string> */
    protected static function readSharedStrings(ZipArchive $zip): array
    {
        $xml = $zip->getFromName('xl/sharedStrings.xml');
        if ($xml === false) {
            return [];
        }

        $shared = [];
        $root = simplexml_load_string($xml);
        if ($root === false) {
            return [];
        }

        $root->registerXPathNamespace('m', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        foreach ($root->xpath('//m:si') ?: [] as $si) {
            $si->registerXPathNamespace('m', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            $parts = $si->xpath('.//m:t') ?: [];
            $text = '';
            foreach ($parts as $part) {
                $text .= (string) $part;
            }
            $shared[] = $text;
        }

        return $shared;
    }

    /**
     * @param list<string> $sharedStrings
     * @return list<list<string>>
     */
    protected static function parseSheetRows(string $sheetXml, array $sharedStrings): array
    {
        $root = simplexml_load_string($sheetXml);
        if ($root === false) {
            throw new RuntimeException('無法解析工作表');
        }

        $root->registerXPathNamespace('m', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $rows = [];
        foreach ($root->xpath('//m:sheetData/m:row') ?: [] as $row) {
            $row->registerXPathNamespace('m', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            $cells = [];
            foreach ($row->xpath('m:c') ?: [] as $cell) {
                $ref = (string) ($cell['r'] ?? '');
                $colIndex = self::columnIndexFromCellRef($ref);
                $type = (string) ($cell['t'] ?? '');
                $valueNode = $cell->children('http://schemas.openxmlformats.org/spreadsheetml/2006/main')->v ?? null;
                $value = $valueNode === null ? '' : (string) $valueNode;
                if ($type === 's' && $value !== '') {
                    $value = $sharedStrings[(int) $value] ?? '';
                } elseif ($type === 'inlineStr') {
                    $ns = 'http://schemas.openxmlformats.org/spreadsheetml/2006/main';
                    $is = $cell->children($ns)->is ?? null;
                    if ($is !== null) {
                        $textNode = $is->children($ns)->t ?? null;
                        $value = $textNode === null ? '' : (string) $textNode;
                    }
                }
                $cells[$colIndex] = $value;
            }

            if ($cells === []) {
                $rows[] = [];
                continue;
            }

            $max = max(array_keys($cells));
            $line = [];
            for ($i = 0; $i <= $max; $i++) {
                $line[] = $cells[$i] ?? '';
            }
            $rows[] = $line;
        }

        return $rows;
    }

    protected static function columnIndexFromCellRef(string $ref): int
    {
        if (!preg_match('/^([A-Z]+)/', strtoupper($ref), $matches)) {
            return 0;
        }

        $letters = $matches[1];
        $index = 0;
        $len = strlen($letters);
        for ($i = 0; $i < $len; $i++) {
            $index = $index * 26 + (ord($letters[$i]) - ord('A') + 1);
        }

        return max(0, $index - 1);
    }
}
