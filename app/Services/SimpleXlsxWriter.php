<?php

namespace App\Services;

use RuntimeException;
use ZipArchive;

/** 產生簡易 .xlsx（單一工作表），供匯入範本下載。 */
final class SimpleXlsxWriter
{
    /**
     * @param  list<list<string|int|float|null>>  $rows
     */
    public static function save(string $path, array $rows, string $sheetName = 'Sheet1'): void
    {
        $sheetName = self::safeSheetName($sheetName);
        $sheetXml = self::buildSheetXml($rows);
        $shared = self::collectSharedStrings($rows);
        $sharedXml = self::buildSharedStringsXml($shared['list']);

        $tmp = tempnam(sys_get_temp_dir(), 'xlsx');
        if ($tmp === false) {
            throw new RuntimeException('無法建立暫存檔');
        }

        $zip = new ZipArchive();
        if ($zip->open($tmp, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            @unlink($tmp);
            throw new RuntimeException('無法建立 Excel 檔案');
        }

        $zip->addFromString('[Content_Types].xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
  <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
  <Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
  <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
</Types>
XML);

        $zip->addFromString('_rels/.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>
XML);

        $zip->addFromString('xl/_rels/workbook.xml.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
  <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>
XML);

        $zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            .'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            .'<sheets><sheet name="'.self::xml($sheetName).'" sheetId="1" r:id="rId1"/></sheets>'
            .'</workbook>');

        $zip->addFromString('xl/styles.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <fonts count="1"><font><sz val="11"/><name val="Calibri"/></font></fonts>
  <fills count="2">
    <fill><patternFill patternType="none"/></fill>
    <fill><patternFill patternType="gray125"/></fill>
  </fills>
  <borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>
  <cellStyleXfs count="1"><xf/></cellStyleXfs>
  <cellXfs count="1"><xf/></cellXfs>
</styleSheet>
XML);

        $zip->addFromString('xl/sharedStrings.xml', $sharedXml);
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);
        $zip->close();

        if (! @rename($tmp, $path)) {
            if (! @copy($tmp, $path)) {
                @unlink($tmp);
                throw new RuntimeException('無法寫入 Excel 檔案');
            }
            @unlink($tmp);
        }
    }

    /**
     * @param  list<list<string|int|float|null>>  $rows
     * @return array{list: list<string>, map: array<string, int>}
     */
    protected static function collectSharedStrings(array $rows): array
    {
        $map = [];
        $list = [];
        foreach ($rows as $row) {
            foreach ($row as $value) {
                if (is_int($value) || is_float($value)) {
                    continue;
                }
                $text = (string) ($value ?? '');
                if (! array_key_exists($text, $map)) {
                    $map[$text] = count($list);
                    $list[] = $text;
                }
            }
        }

        return ['list' => $list, 'map' => $map];
    }

    /**
     * @param  list<string>  $list
     */
    protected static function buildSharedStringsXml(array $list): string
    {
        $count = count($list);
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="'.$count.'" uniqueCount="'.$count.'">';
        foreach ($list as $text) {
            $xml .= '<si><t xml:space="preserve">'.self::xml($text).'</t></si>';
        }
        $xml .= '</sst>';

        return $xml;
    }

    /**
     * @param  list<list<string|int|float|null>>  $rows
     */
    protected static function buildSheetXml(array $rows): string
    {
        $shared = self::collectSharedStrings($rows);
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<sheetData>';

        foreach ($rows as $rIdx => $row) {
            $rowNum = $rIdx + 1;
            $xml .= '<row r="'.$rowNum.'">';
            foreach ($row as $cIdx => $value) {
                $ref = self::columnLetter($cIdx).$rowNum;
                if (is_int($value) || is_float($value)) {
                    $xml .= '<c r="'.$ref.'"><v>'.$value.'</v></c>';
                    continue;
                }
                $text = (string) ($value ?? '');
                $sid = $shared['map'][$text];
                $xml .= '<c r="'.$ref.'" t="s"><v>'.$sid.'</v></c>';
            }
            $xml .= '</row>';
        }

        $xml .= '</sheetData></worksheet>';

        return $xml;
    }

    protected static function columnLetter(int $index): string
    {
        $index += 1;
        $letter = '';
        while ($index > 0) {
            $index--;
            $letter = chr(65 + ($index % 26)).$letter;
            $index = intdiv($index, 26);
        }

        return $letter;
    }

    protected static function safeSheetName(string $name): string
    {
        $name = trim($name);
        $name = str_replace(['\\', '/', '*', '?', ':', '[', ']'], '', $name);
        if ($name === '') {
            $name = 'Sheet1';
        }

        return mb_substr($name, 0, 31);
    }

    protected static function xml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
