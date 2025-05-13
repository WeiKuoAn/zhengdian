<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeetData;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

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
        //
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
            'name'       => 'required|string|max:255',
            'place'      => 'nullable|string|max:255',
            'attend'     => 'nullable|string|max:255',
            'record'     => 'nullable|string',
            'to_do'      => 'nullable|string',
            'cust_to_do' => 'nullable|string',
            'nas_link'   => 'nullable|string',
            'agenda'     => 'nullable|string|max:255',
            'date'       => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time'   => 'nullable|date_format:H:i',
        ]);

        // 使用 findOrFail 確保找得到指定資料
        $data = MeetData::findOrFail($id);

        // 資料更新
        $data->update([
            'user_id'    => $validated['user_id'],
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
}
