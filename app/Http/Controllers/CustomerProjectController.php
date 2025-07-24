<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustProject;
use Illuminate\Support\Facades\Auth;
use App\Services\EncryptionService;
use App\Models\Supplement;
use App\Models\MeetData;

class CustomerProjectController extends Controller
{
    public function index()
    {
        $datas = CustProject::where('user_id', Auth::user()->id)->get();
        return view('customerProject.index', compact('datas'));
    }

    public function sbir_appendix($encrypted_id)
    {
        // 解密ID
        $project_id = EncryptionService::decryptProjectId($encrypted_id);
        
        if (!$project_id) {
            abort(404, '專案不存在');
        }

        // 驗證專案是否屬於當前用戶
        $project = CustProject::where('id', $project_id)
                             ->where('user_id', Auth::user()->id)
                             ->first();

        if (!$project) {
            abort(403, '您沒有權限訪問此專案');
        }

        // 獲取客戶資料
        $cust_data = \App\Models\CustData::where('user_id', Auth::user()->id)->first();
        
        // 獲取附件資料
        $appendix = \App\Models\ProjectAppendix::where('project_id', $project->id)->first();
        
        // 獲取checkbox狀態
        $checkboxesStatus = $appendix ? json_encode($appendix->checkboxes_status) : json_encode([]);

        return view('customerProject.sbir_appendix', compact('project', 'cust_data', 'appendix', 'checkboxesStatus'));
    }

    public function supplement($encrypted_id)
    {
        // 解密ID
        $project_id = EncryptionService::decryptProjectId($encrypted_id);
        
        if (!$project_id) {
            abort(404, '專案不存在');
        }

        // 驗證專案是否屬於當前用戶
        $project = CustProject::where('id', $project_id)
                             ->where('user_id', Auth::user()->id)
                             ->first();

        if (!$project) {
            abort(403, '您沒有權限訪問此專案');
        }

        $supplements = Supplement::where('project_id', $project->id)->orderBy('is_confirmed', 'asc')->orderBy('is_urgent', 'desc')->orderBy('date', 'asc')->get();

        return view('customerProject.sbir_supplement', compact('project', 'supplements'));
    }

    public function supplement_store(Request $request, $project_id)
    {
        $action = $request->input('action'); // 'save' or 'submit'
        $status = ($action === 'submit') ? 1 : 0;

        $supplementIds = $request->input('supplement_id', []);
        $answers = $request->input('answer', []);

        foreach ($supplementIds as $i => $supplementId) {
            $supplement = Supplement::where('project_id', $project_id)->where('id', $supplementId)->first();
            if ($supplement) {
                $supplement->answer = $answers[$i];
                $supplement->status = $status;
                $supplement->save();
            }
        }

        // 重新查詢最新資料
        $project = CustProject::find($project_id);
        $supplements = Supplement::where('project_id', $project_id)
            ->orderBy('is_urgent', 'desc')
            ->orderBy('date', 'asc')
            ->orderBy('is_confirmed', 'asc')
            ->get();

        $msg = $status === 1 ? '已確認送出' : '已暫存';
        return redirect()->back()->with('success', $msg);
    }

    public function Meet()
    {
        $datas = MeetData::where('user_id', Auth::user()->id)->get();

        return view('customerProject.meet', compact('datas'));
    }

    public function MeetCheck($encrypted_id)
    {
        $id = \App\Services\EncryptionService::decryptProjectId($encrypted_id);
        $data = MeetData::find($id);
        return view('customerProject.meet_check', compact('data'));
    }

    public function MeetCheckData(Request $request, $encrypted_id)
    {
        $id = \App\Services\EncryptionService::decryptProjectId($encrypted_id);
        $data = \App\Models\MeetData::findOrFail($id);

        // 更新欄位
        $data->status = 1;
        $data->confirm_time = now();
        $data->save();

        // 直接導回會議列表
        return redirect()->route('customer.meet')->with('success', '會議已確認！');
    }
}
