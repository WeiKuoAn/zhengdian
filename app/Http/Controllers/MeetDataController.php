<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeetData;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class MeetDataController extends Controller
{
    public function index(Request $request)
    {
        $datas = MeetData::orderby('date', 'desc');
        $cust_name = $request->input('cust_name');
        if ($cust_name) {
            $user_datas = User::where('status', 1)->where('group_id', 2)->where('name', 'like', '%' . $cust_name . '%')->get();
            foreach ($user_datas as $user_data) {
                $datas = $datas->orWhere('user_id', $user_data->id);
            }
        }
        $meet_name = $request->input('meet_name');
        if ($meet_name) {
            $datas = $datas->where('name', 'like', '%' . $meet_name . '%');
        }
        $datas = $datas->paginate(50);
        return view('meetData.index')->with('datas', $datas)->with('request', $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today = Carbon::now()->format('Y-m-d');
        $cust_datas = User::where('status', 1)->where('group_id', 2)->get();
        return view('meetData.create')->with('cust_datas', $cust_datas)->with('today', $today);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // 驗證表單輸入
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // 確保 user_id 存在於 users 表中
            'name' => 'required|string|max:255',
            'place' => 'nullable|string|max:255',
            'attend' => 'nullable|string|max:255',
            'record' => 'nullable|string',
            'to_do' => 'nullable|string',
            'cust_to_do' => 'nullable|string',
            'nas_link' => 'nullable|string',
            'agenda' => 'nullable|string|max:255', // 假設是議程，根據需要調整
            'date' => 'nullable|date', // 假設是時間，根據需要調整
            'start_time' => 'nullable|date_format:H:i', // 假設是開始時間，根據需要調整
            'end_time' => 'nullable|date_format:H:i', // 假設是結束時間，根據需要調整
        ]);

        // 儲存會議數據
        $meeting = new MeetData();
        $meeting->user_id = $validated['user_id'];
        $meeting->name = $validated['name'];
        $meeting->place = $validated['place'] ?? null;
        $meeting->attend = $validated['attend'] ?? null;
        $meeting->record = $validated['record'] ?? null;
        $meeting->to_do = $validated['to_do'] ?? null;
        $meeting->cust_to_do = $validated['cust_to_do'] ?? null;
        $meeting->nas_link = $validated['nas_link'] ?? null;
        $meeting->agenda = $validated['agenda'] ?? null;
        $meeting->date = $request->date;
        $meeting->start_time = $request->start_time;
        $meeting->end_time = $request->end_time;
        $meeting->created_by = Auth::user()->id;
        $meeting->save();

        // 返回成功響應
        return redirect()->route('meetDatas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cust_datas = User::where('status', 1)->where('group_id', 2)->get();
        $data = MeetData::where('id', $id)->first();
        return view('meetData.edit')->with('data', $data)->with('cust_datas', $cust_datas);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cust_datas = User::where('status', 1)->where('group_id', 2)->get();
        $data = MeetData::where('id', $id)->first();
        return view('meetData.edit')->with('data', $data)->with('cust_datas', $cust_datas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 驗證表單輸入
        $validated = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'project_id' => 'nullable|string',
            'name'       => 'required|string|max:255',
            'place'      => 'nullable|string|max:255',
            'attend'     => 'nullable|string|max:255',
            'record'     => 'nullable|string',
            'to_do'      => 'nullable|string',
            'cust_to_do' => 'nullable|string',
            'nas_link'   => 'nullable|string',
            'agenda'     => 'nullable|string',
            'date'       => 'nullable|string',
            'start_time' => 'nullable|string',
            'end_time'   => 'nullable|string',
        ]);

        // 使用 findOrFail 確保找得到指定資料
        $data = MeetData::findOrFail($id);

        // 資料更新
        $data->update([
            'user_id'    => $validated['user_id'],
            'project_id' => $validated['project_id'] ?? null,
            'name'       => $validated['name'],
            'place'      => $validated['place']      ?? null,
            'attend'     => $validated['attend']     ?? null,
            'record'     => $validated['record']     ?? null,
            'to_do'      => $validated['to_do']      ?? null,
            'cust_to_do' => $validated['cust_to_do'] ?? null,
            'nas_link'   => $validated['nas_link']   ?? null,
            'agenda'     => $validated['agenda']     ?? null,
            'date'       => $validated['date']       ?? null,
            'start_time' => $validated['start_time'] ?? null,
            'end_time'   => $validated['end_time']   ?? null,
        ]);

        return redirect()->route('meetDatas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $cust_datas = User::where('status', 1)->where('group_id', 2)->get();
        $data = MeetData::where('id', $id)->first();
        return view('meetData.del')->with('data', $data)->with('cust_datas', $cust_datas);
    }
    public function destroy($id)
    {
        $data = MeetData::where('id', $id)->first();
        $data->delete();
        return redirect()->route('meetDatas');
    }

    public function export(Request $request, $id)
    {
        // 驗證輸入欄位
        $data = MeetData::where('id', $id)->first();

        // Word 範本路徑，請確保 meeting.docx 已放在 storage/app/templates
        $templatePath = storage_path('app/templates/meeting.docx');
        if (! file_exists($templatePath)) {
            abort(404, 'Word 模板未找到：' . $templatePath);
        }

        // 加載範本
        $template = new TemplateProcessor($templatePath);

        // 按欄位逐一填充
        $template->setValue('today',      Carbon::parse($data->created_at)->format('Ymd') ?? ' ');
        $template->setValue('agenda',     $data->agenda);

        // 將 date 拆分為「月/日（星期）」及「早上/下午 時間」
        $dt = Carbon::parse($data->created_at);
        // 月/日，不補 0
        $monthDay = $dt->format('n/j');
        // 中文星期映射：0=日,1=一,...6=六
        $weekMap = ['日', '一', '二', '三', '四', '五', '六'];
        $weekday = $weekMap[$dt->dayOfWeek];
        $formattedDate = sprintf('（%s）', $weekday);
        $template->setValue('date',       substr($data->date , 0 ,10).$formattedDate);
        $template->setValue('start_time',       substr($data->start_time, 0, 5));
        $template->setValue('end_time',         substr($data->end_time, 0, 5));
        $template->setValue('place',      $data->place);
        $template->setValue('attend',     $data->attend);
        $template->setValue('record',     $data->record);
        $template->setValue('nas_link',   $data->nas_link   ?? '');
        $template->setValue('cust_to_do', $data->cust_to_do ?? '');
        $template->setValue('to_do',      $data->to_do      ?? '');

        // 產生臨時檔案並輸出下載
        $fileName = $data->name . now()->format('Ymd_His') . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'meeting_') . '.docx';
        $template->saveAs($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function exportWordWithHtml($id)
    {
        $data = MeetData::where('id', $id)->first();

        // 1. 將 HTML 轉成 WordML（富文字欄位）
        $agendaWordML = $this->htmlToWordXml($data->agenda ?? '');
        $recordWordML = $this->htmlToWordXml($data->record ?? '');
        $toDoWordML = $this->htmlToWordXml($data->to_do ?? '');
        $custToDoWordML = $this->htmlToWordXml($data->cust_to_do ?? '');
        
        // 2. 純文字欄位直接轉 WordML
        $nameWordML = $this->buildRunXml($data->name ?? '');
        $attendWordML = $this->buildRunXml($data->attend ?? '');
        $nasLinkWordML = $this->buildRunXml($data->nas_link ?? '');
        $placeWordML = $this->buildRunXml($data->place ?? '');
        $startTimeWordML = $this->buildRunXml($data->start_time ?? '');
        $endTimeWordML = $this->buildRunXml($data->end_time ?? '');
        
        // 3. 合併日期時間格式
        $dateTimeText = '';
        if ($data->date) {
            $dateTimeText = date('Y-m-d', strtotime($data->date));
            if ($data->start_time && $data->end_time) {
                $startTime = substr($data->start_time, 0, 5); // 取 HH:MM
                $endTime = substr($data->end_time, 0, 5); // 取 HH:MM
                $dateTimeText .= ' ' . $startTime . '~' . $endTime;
            }
        }
        $dateTimeWordML = $this->buildRunXml($dateTimeText);

        // 2. 解壓 meeting.docx
        $templatePath = storage_path('app/templates/meeting.docx');
        $tempDir = sys_get_temp_dir() . '/meeting_' . uniqid();
        \Illuminate\Support\Facades\File::makeDirectory($tempDir, 0755, true);
        $zip = new \ZipArchive;
        $zip->open($templatePath);
        $zip->extractTo($tempDir);
        $zip->close();

        // 3. 讀取 document.xml
        $docXmlPath = $tempDir . '/word/document.xml';
        $documentXml = \Illuminate\Support\Facades\File::get($docXmlPath);

        // 4. 替換 placeholder
        $search = [
            '##HTML_PLACEHOLDER_agenda##',
            '##HTML_PLACEHOLDER_name##',
            '##HTML_PLACEHOLDER_attend##',
            '##HTML_PLACEHOLDER_nas_link##',
            '##HTML_PLACEHOLDER_place##',
            '##HTML_PLACEHOLDER_start_time##',
            '##HTML_PLACEHOLDER_end_time##',
            '##HTML_PLACEHOLDER_date_time##',
            '##HTML_PLACEHOLDER_record##',
            '##HTML_PLACEHOLDER_to_do##',
            '##HTML_PLACEHOLDER_cust_to_do##',
        ];
        $replace = [
            $agendaWordML,
            '<w:p><w:pPr><w:ind w:left="0"/></w:pPr>' . $nameWordML . '</w:p>',
            '<w:p><w:pPr><w:ind w:left="0"/></w:pPr>' . $attendWordML . '</w:p>',
            '<w:p><w:pPr><w:ind w:left="0"/></w:pPr>' . $nasLinkWordML . '</w:p>',
            '<w:p><w:pPr><w:ind w:left="0"/></w:pPr>' . $placeWordML . '</w:p>',
            '<w:p><w:pPr><w:ind w:left="0"/></w:pPr>' . $startTimeWordML . '</w:p>',
            '<w:p><w:pPr><w:ind w:left="0"/></w:pPr>' . $endTimeWordML . '</w:p>',
            '<w:p><w:pPr><w:ind w:left="0"/></w:pPr>' . $dateTimeWordML . '</w:p>',
            $recordWordML,
            $toDoWordML,
            $custToDoWordML,
        ];
        $documentXml = str_replace($search, $replace, $documentXml);

        // 5. 清理多餘的空白段落和換行
        $documentXml = preg_replace('/<w:p>\s*<w:pPr>\s*<w:ind[^>]*\/>\s*<\/w:pPr>\s*<\/w:p>/', '', $documentXml);
        $documentXml = preg_replace('/<w:p>\s*<w:pPr>\s*<w:ind[^>]*\/>\s*<\/w:pPr>\s*<w:r>\s*<w:rPr>\s*<w:rFonts[^>]*\/>\s*<\/w:rPr>\s*<w:t[^>]*>\s*<\/w:t>\s*<\/w:r>\s*<\/w:p>/', '', $documentXml);
        $documentXml = preg_replace('/<w:p>\s*<w:pPr>\s*<w:ind[^>]*\/>\s*<\/w:pPr>\s*<w:r>\s*<w:rPr>\s*<w:rFonts[^>]*\/>\s*<\/w:rPr>\s*<w:t[^>]*>\s*<\/w:t>\s*<\/w:r>\s*<\/w:p>/', '', $documentXml);
        
        // 清理連續的多個段落標籤
        $documentXml = preg_replace('/(<w:p[^>]*>.*?<\/w:p>)\s*(<w:p[^>]*>.*?<\/w:p>)/s', '$1$2', $documentXml);

        // 5. 寫回
        \Illuminate\Support\Facades\File::put($docXmlPath, $documentXml);

        // 6. 壓回 docx
        $newDocxPath = storage_path('app/public/會議記錄_' . $data->name . '_' . now()->format('Ymd') . '.docx');
        $zip = new \ZipArchive;
        $zip->open($newDocxPath, \ZipArchive::CREATE);
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($tempDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $relativePath = substr($file->getRealPath(), strlen($tempDir) + 1);
                $zip->addFile($file->getRealPath(), $relativePath);
            }
        }
        $zip->close();
        \Illuminate\Support\Facades\File::deleteDirectory($tempDir);

        return response()->download($newDocxPath)->deleteFileAfterSend(true);
    }

    private function htmlToWordXml($html)
    {
        // 如果是純文字（沒有 HTML 標籤），返回完整的段落結構
        if (strip_tags($html) === $html) {
            $html = trim($html);
            if ($html === '') {
                return '';
            }
            $runXml = $this->buildRunXml($html);
            return '<w:p><w:pPr><w:ind w:left="0"/></w:pPr>' . $runXml . '</w:p>';
        }
        
        $xml = '';
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        libxml_clear_errors();

        $body = $dom->getElementsByTagName('body')->item(0);
        if (!$body)
            return '';

        foreach ($body->childNodes as $node) {
            if ($node->nodeName === 'p') {
                $xml .= $this->convertParagraph($node);
            } elseif ($node->nodeName === 'table') {
                $xml .= $this->convertTableAdvanced($node);
            } elseif ($node->nodeName === 'ul' || $node->nodeName === 'ol') {
                $xml .= $this->convertList($node);
            }
        }
        
        // 清理多餘的空白段落
        $xml = preg_replace('/<w:p>\s*<w:pPr>\s*<w:ind w:left="0"\/>\s*<\/w:pPr>\s*<\/w:p>/', '', $xml);
        $xml = preg_replace('/<w:p>\s*<w:pPr>\s*<w:ind w:left="0"\/>\s*<\/w:pPr>\s*<w:r>\s*<w:rPr>\s*<w:rFonts[^>]*\/>\s*<\/w:rPr>\s*<w:t[^>]*>\s*<\/w:t>\s*<\/w:r>\s*<\/w:p>/', '', $xml);
        
        return trim($xml);
    }

    private function convertParagraph($node)
    {
        $paragraphXml = '';
        foreach ($node->childNodes as $child) {
            if ($child->nodeName === 'br') {
                $paragraphXml .= '<w:br/>';
            } elseif ($child->nodeType === XML_TEXT_NODE || $child->nodeName === '#text') {
                $text = trim($child->textContent);
                if ($text !== '') {
                    $paragraphXml .= $this->buildRunXml($text);
                }
            } elseif ($child->nodeName === 'span') {
                $text = trim($child->textContent);
                if ($text !== '') {
                    $color = null;
                    if ($child instanceof \DOMElement && $child->hasAttribute('style')) {
                        if (preg_match('/color\s*:\s*([^;]+)/i', $child->getAttribute('style'), $m)) {
                            $color = $this->cssColorToWordColor($m[1]);
                        }
                    }
                    $paragraphXml .= $this->buildRunXml($text, false, false, $color);
                }
            } elseif ($child->nodeName === 'font') {
                $text = trim($child->textContent);
                $color = null;
                if ($child instanceof \DOMElement && $child->hasAttribute('color')) {
                    $color = $this->cssColorToWordColor($child->getAttribute('color'));
                }
                $paragraphXml .= $this->buildRunXml($text, false, false, $color);
            } else {
                $text = trim($child->textContent);
                if ($text !== '') {
                    $isBold = in_array($child->nodeName, ['b', 'strong']);
                    $isItalic = in_array($child->nodeName, ['i', 'em']);
                    $color = null;
                    if ($child instanceof \DOMElement && $child->hasAttribute('style')) {
                        if (preg_match('/color\s*:\s*([^;]+)/i', $child->getAttribute('style'), $m)) {
                            $color = $this->cssColorToWordColor($m[1]);
                        }
                    }
                    $paragraphXml .= $this->buildRunXml($text, $isBold, $isItalic, $color);
                }
            }
        }
        
        // 如果段落內容為空，不產生段落標籤
        if (trim($paragraphXml) === '') {
            return '';
        }
        
        return <<<XML
            <w:p>
              <w:pPr>
                <w:ind w:left="0"/>
              </w:pPr>
              {$paragraphXml}
            </w:p>
            XML;
    }

    private function convertList($listNode)
    {
        $xml = '';
        $isOrdered = $listNode->nodeName === 'ol';
        foreach ($listNode->childNodes as $li) {
            if ($li->nodeName !== 'li')
                continue;
            $text = trim($li->textContent);
            if ($text === '')
                continue;

            $liContent = '';
            foreach ($li->childNodes as $child) {
                if ($child->nodeType === XML_TEXT_NODE || $child->nodeName === '#text') {
                    $text = trim($child->textContent);
                    if ($text !== '') {
                        $liContent .= $this->buildRunXml($text);
                    }
                } else {
                    $text = trim($child->textContent);
                    if ($text !== '') {
                        $isBold = in_array($child->nodeName, ['b', 'strong']);
                        $isItalic = in_array($child->nodeName, ['i', 'em']);
                        $color = null;
                        if ($child instanceof \DOMElement && $child->hasAttribute('style')) {
                            if (preg_match('/color\s*:\s*([^;]+)/i', $child->getAttribute('style'), $m)) {
                                $color = $this->cssColorToWordColor($m[1]);
                            }
                        }
                        $liContent .= $this->buildRunXml($text, $isBold, $isItalic, $color);
                    }
                }
            }
            
            // 如果列表項目內容為空，跳過
            if (trim($liContent) === '') {
                continue;
            }
            
            $numId = $isOrdered ? '2' : '1';
            $xml .= '<w:p>
  <w:pPr>
    <w:ind w:left="1500"/>
    <w:numPr>
      <w:ilvl w:val="0"/>
      <w:numId w:val="' . $numId . '"/>
    </w:numPr>
  </w:pPr>
  ' . $liContent . '
</w:p>';
        }
        return $xml;
    }

    private function convertTableAdvanced($tableNode)
    {
        $tblXml = '<w:tbl>';
        $tblXml .= '
    <w:tblPr>
        <w:tblW w:w="4000" w:type="pct"/>
        <w:tblInd w:w="1100" w:type="dxa"/>
        <w:tblBorders>
            <w:top w:val="single" w:sz="4" w:space="0" w:color="000000"/>
            <w:left w:val="single" w:sz="4" w:space="0" w:color="000000"/>
            <w:bottom w:val="single" w:sz="4" w:space="0" w:color="000000"/>
            <w:right w:val="single" w:sz="4" w:space="0" w:color="000000"/>
            <w:insideH w:val="single" w:sz="4" w:space="0" w:color="000000"/>
            <w:insideV w:val="single" w:sz="4" w:space="0" w:color="000000"/>
        </w:tblBorders>
    </w:tblPr>
';
        $rowspanMap = [];
        foreach ($tableNode->getElementsByTagName('tr') as $rowIdx => $tr) {
            $tblXml .= '<w:tr>';
            $colIdx = 0;
            foreach ($tr->childNodes as $td) {
                if ($td->nodeName !== 'td' && $td->nodeName !== 'th')
                    continue;
                while (isset($rowspanMap[$rowIdx][$colIdx])) {
                    $tblXml .= $rowspanMap[$rowIdx][$colIdx];
                    $colIdx++;
                }
                $colspan = intval($td->getAttribute('colspan')) ?: 1;
                $rowspan = intval($td->getAttribute('rowspan')) ?: 1;
                $tcPr = '<w:tcPr><w:tcW w:w="1500" w:type="dxa"/>';
                if ($colspan > 1) {
                    $tcPr .= '<w:gridSpan w:val="' . $colspan . '"/>';
                }
                if ($rowspan > 1) {
                    $tcPr .= '<w:vMerge w:val="restart"/>';
                    for ($i = 1; $i < $rowspan; $i++) {
                        $rowspanMap[$rowIdx + $i][$colIdx] = '
<w:tc>
  <w:tcPr>
    <w:tcW w:w="1500" w:type="dxa"/>
    <w:vMerge/>
  </w:tcPr>
  <w:p/>
</w:tc>
';
                    }
                }
                $tcPr .= '</w:tcPr>';
                $cellParagraphs = [];
                foreach ($td->childNodes as $child) {
                    if ($child->nodeName === 'p') {
                        $innerParagraph = '';
                        foreach ($child->childNodes as $innerChild) {
                            if ($innerChild->nodeType === XML_TEXT_NODE || $innerChild->nodeName === '#text') {
                                $text = trim($innerChild->textContent);
                                if ($text !== '') {
                                    $innerParagraph .= $this->buildRunXml($text);
                                }
                            } else {
                                $text = trim($innerChild->textContent);
                                if ($text !== '') {
                                    $isBold = in_array($innerChild->nodeName, ['b', 'strong']);
                                    $isItalic = in_array($innerChild->nodeName, ['i', 'em']);
                                    $color = null;
                                    if ($innerChild instanceof \DOMElement && $innerChild->hasAttribute('style')) {
                                        if (preg_match('/color\s*:\s*([^;]+)/i', $innerChild->getAttribute('style'), $m)) {
                                            $color = $this->cssColorToWordColor($m[1]);
                                        }
                                    }
                                    $innerParagraph .= $this->buildRunXml($text, $isBold, $isItalic, $color);
                                }
                            }
                        }
                        if ($innerParagraph !== '') {
                            $cellParagraphs[] = '<w:p>' . $innerParagraph . '</w:p>';
                        }
                    } elseif ($child->nodeName === 'br') {
                        if (!empty($cellParagraphs)) {
                            $last = array_pop($cellParagraphs);
                            $last = str_replace('</w:p>', '<w:br/></w:p>', $last);
                            $cellParagraphs[] = $last;
                        }
                    } elseif ($child->nodeType === XML_TEXT_NODE || $child->nodeName === '#text') {
                        $text = trim($child->textContent);
                        if ($text !== '') {
                            $cellParagraphs[] = '<w:p>' . $this->buildRunXml($text) . '</w:p>';
                        }
                    } else {
                        $text = trim($child->textContent);
                        if ($text !== '') {
                            $isBold = in_array($child->nodeName, ['b', 'strong']);
                            $isItalic = in_array($child->nodeName, ['i', 'em']);
                            $color = null;
                            if ($child instanceof \DOMElement && $child->hasAttribute('style')) {
                                if (preg_match('/color\s*:\s*([^;]+)/i', $child->getAttribute('style'), $m)) {
                                    $color = $this->cssColorToWordColor($m[1]);
                                }
                            }
                            $cellParagraphs[] = '<w:p>' . $this->buildRunXml($text, $isBold, $isItalic, $color) . '</w:p>';
                        }
                    }
                }
                $cellContentXml = implode('', $cellParagraphs);
                $tblXml .= '
<w:tc>
  ' . $tcPr . '
  ' . $cellContentXml . '
</w:tc>
';
                $colIdx += $colspan;
            }
            $tblXml .= '</w:tr>';
        }
        $tblXml .= '</w:tbl>';
        return $tblXml;
    }

    private function buildRunXml($text, $isBold = false, $isItalic = false, $color = null)
    {
        $text = htmlspecialchars($text);
        $bold = $isBold ? '<w:b/>' : '';
        $italic = $isItalic ? '<w:i/>' : '';
        $colorXml = $color ? '<w:color w:val="' . $color . '"/>' : '';
        
        // 判斷是否包含中文字符
        $hasChinese = preg_match('/[\x{4e00}-\x{9fff}]/u', $text);
        $fontFamily = $hasChinese ? '標楷體' : 'Times New Roman';
        
        return <<<XML
            <w:r>
              <w:rPr>
                <w:rFonts w:ascii="{$fontFamily}" w:eastAsia="標楷體" w:hAnsi="{$fontFamily}"/>
                {$bold}
                {$italic}
                {$colorXml}
              </w:rPr>
              <w:t xml:space="preserve">{$text}</w:t>
            </w:r>
            XML;
    }

    private function cssColorToWordColor($cssColor)
    {
        $cssColor = trim($cssColor);
        if (preg_match('/^#([0-9a-f]{6})$/i', $cssColor, $m)) {
            return strtoupper($m[1]);
        }
        if (preg_match('/^#([0-9a-f]{3})$/i', $cssColor, $m)) {
            return strtoupper($m[1][0] . $m[1][0] . $m[1][1] . $m[1][1] . $m[1][2] . $m[1][2]);
        }
        if (preg_match('/rgb\\((\\d+),\\s*(\\d+),\\s*(\\d+)\\)/i', $cssColor, $m)) {
            return sprintf('%02X%02X%02X', $m[1], $m[2], $m[3]);
        }
        $map = [
            'black' => '000000',
            'red' => 'FF0000',
            'green' => '00FF00',
            'blue' => '0000FF',
            'yellow' => 'FFFF00',
            'gray' => '808080',
            'white' => 'FFFFFF',
            'orange' => 'FFA500',
            'purple' => '800080',
            'pink' => 'FFC0CB',
            'brown' => 'A52A2A',
            'cyan' => '00FFFF',
            'magenta' => 'FF00FF',
        ];
        $cssColor = strtolower($cssColor);
        return $map[$cssColor] ?? null;
    }
}
