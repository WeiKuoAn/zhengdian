<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskTemplate;
use App\Services\TaskTemplateImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\CheckStatus;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TaskTemplateController extends Controller
{
    protected function ensureCanDeleteSetting(): void
    {
        if ((int) (Auth::user()->level ?? 2) === 2) {
            abort(403, '一般使用者無法刪除設定資料');
        }
    }

    protected function ensureCanImportSetting(): void
    {
        if ((int) (Auth::user()->level ?? 2) === 2) {
            abort(403, '一般使用者無法匯入設定資料');
        }
    }

    protected function ensureCanManageSetting(): void
    {
        if ((int) (Auth::user()->level ?? 2) === 2) {
            abort(403, '一般使用者無法管理設定資料');
        }
    }

    public function getTaskTemplate(Request $request)
    {
        $checkStatusId = (int) $request->input('check_status_id');
        if ($checkStatusId <= 0) {
            return response()->json([]);
        }

        $stage = CheckStatus::query()->find($checkStatusId);
        if ($stage === null) {
            return response()->json([]);
        }

        $task_template_ids = TaskTemplate::sortByScheduleOrder(
            TaskTemplate::with(['check_status_data', 'check_status_parent_data'])
                ->listed()
                ->where(function ($query) use ($checkStatusId, $stage) {
                    $query->where('check_status_id', $checkStatusId);
                    if ($stage->parent_id) {
                        $query->orWhere(function ($query) use ($stage) {
                            $query->whereNull('check_status_id')
                                ->where('check_status_parent_id', $stage->parent_id);
                        });
                    }
                })
                ->get()
        );

        return response()->json($task_template_ids);
    }

    public function index(Request $request)
    {
        $statusFilter = $request->input('status_filter', 'up');
        if (! in_array($statusFilter, ['all', 'up', 'down'], true)) {
            $statusFilter = 'up';
        }

        $datas = TaskTemplate::sortByScheduleOrder(
            TaskTemplate::with(['check_status_parent_data', 'check_status_data'])
                ->byListStatusFilter($statusFilter)
                ->get()
        );

        return view('task_template.index')
            ->with('datas', $datas)
            ->with('statusFilter', $statusFilter);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $check_status_parent_ids = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        return view('task_template.create')->with('check_status_parent_ids',$check_status_parent_ids);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:500'],
            'check_status_parent_id' => ['nullable', 'integer'],
            'check_status_id' => ['nullable', 'integer'],
            'description' => ['nullable', 'string', 'max:65535'],
            'duration_hours' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'in:up,down'],
            'seq' => ['nullable', 'string', 'max:50'],
        ]);

        $data = new TaskTemplate;
        $data->name = $validated['name'];
        $data->check_status_parent_id = $validated['check_status_parent_id'] ?? null;
        $data->check_status_id = $validated['check_status_id'] ?? null;
        $data->description = $validated['description'] ?? null;
        $data->duration_hours = max(0, (float) ($validated['duration_hours'] ?? 0));
        $data->status = $validated['status'] ?? 'up';
        $data->seq = $validated['seq'] ?? '0';
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('TaskTemplate');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = TaskTemplate::where('id', $id)->first();
        $check_status_parent_ids = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        $check_status_ids = CheckStatus::orderby('seq', 'asc')->whereNotNull('parent_id')->get();
        return view('task_template.edit')->with('data', $data)->with('check_status_parent_ids', $check_status_parent_ids)->with('check_status_ids', $check_status_ids);
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:500'],
            'check_status_parent_id' => ['nullable', 'integer'],
            'check_status_id' => ['nullable', 'integer'],
            'description' => ['nullable', 'string', 'max:65535'],
            'duration_hours' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'in:up,down'],
            'seq' => ['nullable', 'string', 'max:50'],
        ]);

        $data = TaskTemplate::where('id', $id)->firstOrFail();
        $data->name = $validated['name'];
        $data->check_status_parent_id = $validated['check_status_parent_id'] ?? null;
        $data->check_status_id = $validated['check_status_id'] ?? null;
        $data->description = $validated['description'] ?? null;
        $data->duration_hours = max(0, (float) ($validated['duration_hours'] ?? 0));
        $data->status = $validated['status'] ?? 'up';
        $data->seq = $validated['seq'] ?? '0';
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('TaskTemplate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->ensureCanDeleteSetting();
        $data = TaskTemplate::where('id', $id)->first();
        $check_status_parent_ids = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        $check_status_ids = CheckStatus::orderby('seq', 'asc')->whereNotNull('parent_id')->get();
        return view('task_template.del')->with('data', $data)->with('check_status_parent_ids', $check_status_parent_ids)->with('check_status_ids', $check_status_ids);
    }
    public function destroy($id)
    {
        $this->ensureCanDeleteSetting();
        $data = TaskTemplate::where('id', $id)->first();
        $data->delete();
        return redirect()->route('TaskTemplate');
    }

    public function downloadImportTemplate(): BinaryFileResponse
    {
        $this->ensureCanImportSetting();

        $path = base_path('專案-流程表（更新系統用）.xlsx');
        if (!is_file($path)) {
            abort(404, '找不到匯入範本檔');
        }

        return response()->download($path, '派工項目匯入範本.xlsx');
    }

    public function import(Request $request, TaskTemplateImportService $importService): RedirectResponse
    {
        $this->ensureCanImportSetting();

        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx', 'max:5120'],
        ]);

        $result = $importService->importFromXlsx($request->file('file')->getRealPath());

        $redirect = redirect()->route('TaskTemplate');
        $summary = '匯入完成：新增 ' . $result['created'] . ' 筆、更新 ' . $result['updated'] . ' 筆';
        if ($result['skipped'] > 0) {
            $summary .= '、略過 ' . $result['skipped'] . ' 筆';
        }
        if (!empty($result['auto_created_statuses'])) {
            $summary .= '（已自動建立：' . implode('、', $result['auto_created_statuses']) . '）';
        }

        if ($result['created'] === 0 && $result['updated'] === 0 && $result['errors'] !== []) {
            return $redirect
                ->with('error', '匯入失敗，請確認 Excel 格式與系統中的專案狀態／階段名稱是否一致')
                ->with('import_errors', array_slice($result['errors'], 0, 20));
        }

        $redirect = $redirect->with('success', $summary);
        if ($result['errors'] !== []) {
            $redirect->with('import_errors', array_slice($result['errors'], 0, 20));
        }

        return $redirect;
    }

    public function batchTakeDown(Request $request): RedirectResponse
    {
        $this->ensureCanManageSetting();

        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:task_templates,id'],
        ]);

        $count = TaskTemplate::query()
            ->whereIn('id', $validated['ids'])
            ->update(['status' => 'down']);

        $statusFilter = $request->input('status_filter', 'up');
        if (! in_array($statusFilter, ['all', 'up', 'down'], true)) {
            $statusFilter = 'up';
        }

        return redirect()
            ->route('TaskTemplate', ['status_filter' => $statusFilter])
            ->with('success', '已批次下架 ' . $count . ' 筆派工項目');
    }

    public function updateSort(Request $request): RedirectResponse
    {
        $this->ensureCanManageSetting();

        $validated = $request->validate([
            'seq' => ['required', 'array'],
            'seq.*' => ['nullable', 'string', 'max:50'],
        ]);

        foreach ($validated['seq'] as $id => $seq) {
            TaskTemplate::query()
                ->where('id', (int) $id)
                ->update(['seq' => (string) ($seq ?? '0')]);
        }

        $statusFilter = $request->input('status_filter', 'up');
        if (! in_array($statusFilter, ['all', 'up', 'down'], true)) {
            $statusFilter = 'up';
        }

        return redirect()
            ->route('TaskTemplate', ['status_filter' => $statusFilter])
            ->with('success', '排序已儲存');
    }
}
