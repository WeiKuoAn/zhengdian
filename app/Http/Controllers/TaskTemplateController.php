<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskTemplate;
use Illuminate\Support\Facades\Auth;
use App\Models\CheckStatus;

class TaskTemplateController extends Controller
{
    protected function ensureCanDeleteSetting(): void
    {
        if ((int) (Auth::user()->level ?? 2) === 2) {
            abort(403, '一般使用者無法刪除設定資料');
        }
    }

    public function getTaskTemplate(Request $request)
    {
        $check_status_id = $request->input('check_status_id');
        $task_template_ids = TaskTemplate::with('check_status_data')
            ->where('check_status_id', $check_status_id)
            ->get()
            ->sort(function ($a, $b) {
                $aStageSeq = (string) optional($a->check_status_data)->seq;
                $bStageSeq = (string) optional($b->check_status_data)->seq;
                $stageCompare = strnatcmp($aStageSeq, $bStageSeq);
                if ($stageCompare !== 0) {
                    return $stageCompare;
                }
                return strnatcmp((string) ($a->seq ?? ''), (string) ($b->seq ?? ''));
            })
            ->values();
        return response()->json($task_template_ids);
    }

    public function index(Request $request)
    {
        $datas = TaskTemplate::with(['check_status_parent_data', 'check_status_data'])
            ->get()
            ->sort(function ($a, $b) {
                $aStageSeq = (string) optional($a->check_status_data)->seq;
                $bStageSeq = (string) optional($b->check_status_data)->seq;
                $stageCompare = strnatcmp($aStageSeq, $bStageSeq);
                if ($stageCompare !== 0) {
                    return $stageCompare;
                }
                return strnatcmp((string) ($a->seq ?? ''), (string) ($b->seq ?? ''));
            })
            ->values();
        return view('task_template.index')->with('datas', $datas);
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
        ]);

        $data = new TaskTemplate;
        $data->name = $validated['name'];
        $data->check_status_parent_id = $validated['check_status_parent_id'] ?? null;
        $data->check_status_id = $validated['check_status_id'] ?? null;
        $data->description = $validated['description'] ?? null;
        $data->duration_hours = max(0, (float) ($validated['duration_hours'] ?? 0));
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
        ]);

        $data = TaskTemplate::where('id', $id)->firstOrFail();
        $data->name = $validated['name'];
        $data->check_status_parent_id = $validated['check_status_parent_id'] ?? null;
        $data->check_status_id = $validated['check_status_id'] ?? null;
        $data->description = $validated['description'] ?? null;
        $data->duration_hours = max(0, (float) ($validated['duration_hours'] ?? 0));
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
}
