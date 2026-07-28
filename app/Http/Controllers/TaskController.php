<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskItem;
use App\Models\TaskTemplate;
use App\Models\User;
use App\Models\CheckStatus;
use App\Models\CustProject;
use App\Models\ProjectMilestones;
use App\Models\TaskEstimatedEndAdjustment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\DispatchNotificationService;

class TaskController extends Controller
{
    protected ?DispatchNotificationService $dispatchNotificationService = null;

    protected function dispatchNotification(): DispatchNotificationService
    {
        return $this->dispatchNotificationService ??= app(DispatchNotificationService::class);
    }

    /** @return array<int, array{id: int, name: string}> */
    protected function buildExecutorsFromUserIds(array $userIds): array
    {
        $executors = [];
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user && !empty($user->name)) {
                $executors[] = ['id' => $user->id, 'name' => $user->name];
            }
        }

        return $executors;
    }

    protected function sendTaskDispatchNotification(
        Request $request,
        Task $task,
        array $executors,
        bool $shouldSend
    ): void {
        if (!$shouldSend || $executors === []) {
            return;
        }

        $project = CustProject::find($request->project_id ?? $task->project_id);
        if (!$project) {
            return;
        }

        try {
            $scheduledDate = trim((string) $request->input('estimated_end_date', ''));
            if ($scheduledDate === '' && !empty($task->estimated_end)) {
                $scheduledDate = Carbon::parse($task->estimated_end)->format('Y-m-d');
            }
            if ($scheduledDate === '') {
                $scheduledDate = Carbon::now()->format('Y-m-d');
            }

            $template = TaskTemplate::find($request->template_id ?? $task->template_id);
            $dispatchContent = trim((string) ($request->comments ?? $task->comments ?? ''));
            if ($dispatchContent === '') {
                $dispatchContent = (string) ($template->description ?? $template->name ?? $task->name);
            }

            $dispatchItem = $template
                ? $this->dispatchNotification()->buildDispatchItemLabel($template)
                : (string) $task->name;

            $this->dispatchNotification()->sendForProject(
                $project,
                $dispatchItem,
                $scheduledDate,
                $dispatchContent,
                $executors
            );
        } catch (\Throwable $e) {
            Log::warning('dispatch_webhook_send_failed', [
                'project_id' => $project->id,
                'task_id' => $task->id,
                'message' => $e->getMessage(),
            ]);
        }
    }

    protected function sendTaskAdjustmentNotification(Task $task, string $adjustedEnd, ?string $note = null): void
    {
        $this->dispatchNotification()->resetSkipped();

        $task->loadMissing(['items.user_data', 'task_template_data', 'project_data']);
        $project = $task->project_data;
        if (! $project) {
            return;
        }

        $executors = $task->items
            ->map(fn ($item) => [
                'id' => (int) $item->user_id,
                'name' => (string) (optional($item->user_data)->name ?? ''),
            ])
            ->filter(fn ($row) => $row['id'] > 0 && $row['name'] !== '')
            ->unique('id')
            ->values()
            ->all();

        if ($executors === []) {
            return;
        }

        try {
            $template = $task->task_template_data;
            $dispatchItem = $template
                ? $this->dispatchNotification()->buildDispatchItemLabel($template)
                : (string) $task->name;

            $dispatchContent = trim((string) ($task->comments ?? ''));
            if ($dispatchContent === '') {
                $dispatchContent = (string) ($template->description ?? $template->name ?? $task->name);
            }

            $originalScheduledAt = ! empty($task->estimated_end)
                ? Carbon::parse($task->estimated_end)->format('Y/m/d H:i')
                : '尚未設定';
            $adjustedScheduledAt = Carbon::parse($adjustedEnd)->format('Y/m/d H:i');

            $this->dispatchNotification()->sendAdjustmentForProject(
                $project,
                $dispatchItem,
                $originalScheduledAt,
                $adjustedScheduledAt,
                $dispatchContent,
                $executors,
                $note
            );
        } catch (\Throwable $e) {
            Log::warning('dispatch_adjust_webhook_send_failed', [
                'project_id' => $project->id,
                'task_id' => $task->id,
                'message' => $e->getMessage(),
            ]);
        }
    }

    protected function redirectToTaskList(string $successMessage)
    {
        $redirect = redirect()->route('task')->with('success', $successMessage);
        $warning = $this->dispatchNotification()->skippedWarningMessage();
        if ($warning !== null) {
            $redirect->with('warning', $warning);
        }

        return $redirect;
    }

    protected function syncMilestoneLinkedTask(Task $task, ?int $oldProjectId = null, ?int $oldTemplateId = null): void
    {
        ProjectMilestones::syncLinkedTaskFromDispatch($task, $oldProjectId, $oldTemplateId);
    }

    /** 任務確認完成後，同步專案排程實際完成時間。 */
    protected function syncMilestoneFormalDate(Task $task): void
    {
        ProjectMilestones::syncFormalDateFromTask($task);
    }

    public function getTaskDetails($id)
    {
        $task = Task::with('items.user_data')->find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json([
            'id' => $task->id,
            'check_status_id' => $task->check_status_id,
            'project_id' => $task->project_id,
            'template_id' => $task->template_id,
            'estimated_end_date' => $task->estimated_end ? substr($task->estimated_end, 0, 10) : null,
            'estimated_end_time' => $task->estimated_end ? substr($task->estimated_end, 11, 5) : null,
            'priority' => $task->priority,
            'comments' => $task->comments,
            'status' => $task->status,
            'items' => $task->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'user_id' => $item->user_id,
                    'user_name' => optional($item->user_data)->name,
                    'status' => (int) $item->status,
                    'status_text' => $item->status(),
                    'end_time' => $item->end_time,
                    'context' => $item->context ?? '', // 如果 context 為 null，設置為空字串
                ];
            }),
        ]);
    }

    public function updateStatus(Request $request, TaskItem $task)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'end_date' => 'nullable|date',
            'end_time' => 'nullable|string',
            'execution_time' => 'nullable|string',
            'order' => 'nullable|array',
        ]);

        $statusMapping = [
            'not-started' => 0, // 未開始
            'in-progress' => 1, // 進行中
            'implement' => 2,   // 執行中
            'completed' => 8,   // 已完成
            'confirmed' => 9,   // 主管確認完成
        ];

        if (array_key_exists($validated['status'], $statusMapping)) {
            $updateData = ['status' => $statusMapping[$validated['status']]];

            // 如果狀態變為 "進行中"，設置開始時間
            if ($statusMapping[$validated['status']] === 1 && $task->status !== 1) {
                $updateData['start_time'] = Carbon::now();
            }

            // 如果狀態變為 "已完成"，設置完成時間和執行時長
            if ($statusMapping[$validated['status']] === 8) {
                if (!empty($validated['end_date']) && !empty($validated['end_time'])) {
                    $doneDateTime = Carbon::parse($validated['end_date'] . ' ' . $validated['end_time']);
                    $updateData['end_time'] = $doneDateTime;
                } else {
                    $updateData['end_time'] = null; // 如果日期或時間無效，設為 null 或其他默認值
                }

                // 設置執行時長，檢查是否存在 execution_time
                $updateData['done_time'] = $validated['execution_time'] ?? null;
            }



            $task->update($updateData);

            // 如果有序列更新，更新 task_item 的順序
            if (isset($validated['order'])) {
                foreach ($validated['order'] as $item) {
                    TaskItem::where('id', $item['id'])->update(['seq' => $item['seq']]);
                }
            }

            // 更新父任務的狀態
            // 更新父任務的狀態
            $taskId = $task->task_id;
            $taskItems = TaskItem::where('task_id', $taskId)->get();
            $allStatuses = $taskItems->pluck('status')->toArray();

            if (count($allStatuses) > 0 && count(array_unique($allStatuses)) === 1 && $allStatuses[0] == 1) {
                // **所有** taskItems 的 status 都是 1，則進入「接收派工」狀態
                $newTaskStatus = 2;
            } elseif (in_array(2, $allStatuses)) {
                // 存在 status = 2 的任務項目，則進入「執行中」
                $newTaskStatus = 3;
            } elseif (count(array_unique($allStatuses)) === 1 && $allStatuses[0] == 9) {
                // **所有** taskItems 的 status 都是 9，則整體為「已完成」
                $newTaskStatus = 9;
                $parentTask = Task::find($taskId);
                if ($parentTask) {
                    if (empty($parentTask->actual_end)) {
                        $parentTask->actual_end = Carbon::now();
                    }
                    $parentTask->status = 9;
                    $parentTask->save();
                    $this->syncMilestoneFormalDate($parentTask);
                }
            } elseif (count(array_unique($allStatuses)) === 1 && $allStatuses[0] == 8) {
                // **所有** taskItems 的 status 都是 8，則進入「人員已完成，待確認」狀態
                $newTaskStatus = 8;
            } elseif (count(array_unique($allStatuses)) === 1 && (int) $allStatuses[0] === 7) {
                $newTaskStatus = 7;
            } elseif (count(array_diff($allStatuses, [8, 9])) === 0 && in_array(8, $allStatuses)) {
                // 若為 8/9 混合，尚有待確認，維持「待確認」
                $newTaskStatus = 8;
            } else {
                // 其他狀況則維持「送出派工」
                $newTaskStatus = 1;
            }

            // 更新父任務狀態
            Task::where('id', $taskId)->update(['status' => $newTaskStatus]);


            Task::where('id', $taskId)->update(['status' => $newTaskStatus]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => '無效的狀態'], 400);
    }




    public function index(Request $request)
    {
        $task_templates = TaskTemplate::get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        $datas = Task::query()
            ->with(['project_data.user_data', 'task_template_data', 'items.user_data'])
            ->whereNotNull('project_id')
            ->whereNotNull('template_id');

        // 如果提供了 task_template_id，過濾數據
        $task_template_id = $request->input('task_template_id');
        if ($task_template_id && $task_template_id !== "null") {
            $datas->where('template_id', $task_template_id);
        }

        $status = $request->input('status');
        if ($status && $status !== "null") {
            $datas->where('status', $status);
        }

        // //搜尋派工人員
        // $user_id = $request->input('user_id');
        // if ($user_id && $user_id !== "null") {
        //     $datas->where('created_by', $user_id);
        // }

        //搜尋被派工人員
        $user_id = $request->input('user_id');
        if ($user_id && $user_id !== "null") {
            $taskItemIds = TaskItem::where('user_id', $user_id)->pluck('task_id'); // 獲取符合條件的用戶 ID 列表
            $datas->whereIn('id', $taskItemIds); // 篩選出符合用戶 ID 的專案
        }

        // 篩選客戶名稱
        $project_name = $request->input('project_name');
        if ($project_name) {
            $userIds = User::where('status', 1)
            ->where('group_id', 2)
            ->where('name', 'like', '%' . $project_name . '%')
            ->pluck('id'); // 獲取符合條件的用戶 ID 列表
            $projectIds = CustProject::where('name', 'like', '%' . $project_name . '%')->orWhereIn('user_id',$userIds)->pluck('id'); // 獲取符合條件的用戶 ID 列表
            $datas->where(function ($query) use ($projectIds, $project_name) {
                $query->whereIn('project_id', $projectIds)
                    ->orWhere('name', 'like', '%' . $project_name . '%');
            });
        }

        // 依預計完成時間最新到最舊排序，並分頁顯示50筆
        $datas = $datas->orderBy('estimated_end', 'desc')->paginate(50);
        return view('task.index')->with('datas', $datas)->with('request', $request)->with('task_templates', $task_templates)->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cust_projects = CustProject::get();
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        return view('task.create')->with('task_templates', $task_templates)->with('check_statuss', $check_statuss)->with('cust_projects', $cust_projects)->with('users', $users);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->dispatchNotification()->resetSkipped();

        $data = new Task;
        $data->type = 'group';
        $data->name = $request->name;
        $data->project_id = $request->project_id;
        $data->template_id = $request->template_id;
        $data->check_status_id = $request->check_status_id;
        $data->created_by = Auth::user()->id;
        $data->estimated_end = $request->estimated_end_date . ' ' . $request->estimated_end_time . ':00';
        $data->priority = $request->priority;
        $data->status = $request->status;
        $data->comments = $request->comments;
        $data->save();
        $this->syncMilestoneLinkedTask($data);

        $user_ids = $request->input('user_ids');
        $contexts = $request->input('contexts');

        // 抓取儲存後的 task_id
        $task_id = $data->id;
        foreach ($user_ids as $index => $user_id) {
            // 儲存資料到資料庫或其他操作
            TaskItem::create([
                'user_id' => $user_id,
                'context' => $contexts[$index],
                'task_id' => $task_id,  // 假設任務ID已存在
                'status' => '0',
                'start_time' => Carbon::now()->locale('zh-tw'),
            ]);
        }

        $executors = $this->buildExecutorsFromUserIds($user_ids);
        $this->sendTaskDispatchNotification($request, $data, $executors, true);

        return $this->redirectToTaskList('派工已新增');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cust_projects = CustProject::get();
        $data = Task::where('id', $id)->first();
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        return view('task.edit')->with('data', $data)->with('task_templates', $task_templates)->with('cust_projects', $cust_projects)->with('check_statuss', $check_statuss)->with('users', $users);
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
        $this->dispatchNotification()->resetSkipped();

        $data = Task::findOrFail($id);
        $data->loadMissing('items.user_data');
        $oldDate = !empty($data->estimated_end) ? Carbon::parse($data->estimated_end)->format('Y-m-d') : null;
        $oldContent = (string) ($data->comments ?? '');
        $oldExecutors = $data->items->map(fn ($item) => [
            'id' => (int) $item->user_id,
            'name' => (string) (optional($item->user_data)->name ?? ''),
        ])->all();

        $oldProjectId = (int) ($data->project_id ?? 0);
        $oldTemplateId = (int) ($data->template_id ?? 0);
        $data->type = 'group';
        $data->name = $request->name;
        $data->project_id = $request->project_id;
        $data->template_id = $request->template_id;
        $data->check_status_id = $request->check_status_id;
        $data->created_by = Auth::user()->id;
        $data->estimated_end = $request->estimated_end_date . ' ' . $request->estimated_end_time . ':00';
        $data->priority = $request->priority;
        $data->status = $request->status;
        $data->comments = $request->comments;
        $data->save();
        $this->syncMilestoneLinkedTask($data, $oldProjectId, $oldTemplateId);

        // 定義 Task 狀態對應到 TaskItem 狀態的映射
        $statusMapping = [
            '1' => '0', // 送出派工 → 已發送，待確認
            '2' => '1', // 已接收 → 已接收
            '3' => '2', // 執行中 → 執行中
            '8' => '8', // 人員已完成，待確認 → 已完成
            '9' => '9', // 已完成 → 確認完成
        ];

        // 取得對應的 TaskItem 狀態
        $taskItemStatus = $statusMapping[$data->status] ?? null;

        // 取得現有的 TaskItem 資料
        $existingTaskItems = TaskItem::where('task_id', $id)->get();
        $existingData = $existingTaskItems->map(function ($item) {
            return ['user_id' => $item->user_id, 'context' => $item->context];
        })->toArray();
        // dd($existingData);
        // 準備新的 TaskItem 資料
        $newData = [];
        $user_ids = $request->input('user_ids');
        $contexts = $request->input('contexts');

        foreach ($user_ids as $index => $user_id) {
            $newData[] = [
                'user_id' => $user_id,
                'context' => $contexts[$index],
            ];
        }

        // 只有當資料有變動時才更新
        if ($existingData !== $newData) {
            TaskItem::where('task_id', $id)->delete();

            foreach ($newData as $item) {
                TaskItem::create(array_merge($item, [
                    'task_id' => $id,
                    'status' => $taskItemStatus, // 設定 TaskItem 的 status
                ]));
            }
        } else {
            // 如果 TaskItem 沒有變動，但 Task 狀態變更了，還是要更新 status
            if ($taskItemStatus !== null) {
                TaskItem::where('task_id', $id)->update(['status' => $taskItemStatus]);
            }
        }

        $user_ids = $request->input('user_ids', []);
        $executors = $this->buildExecutorsFromUserIds($user_ids);
        $scheduledDate = trim((string) $request->input('estimated_end_date', ''));
        if ($scheduledDate === '') {
            $scheduledDate = Carbon::now()->format('Y-m-d');
        }
        $shouldSend = $this->dispatchNotification()->shouldSend(
            $oldDate,
            $oldContent,
            $oldExecutors,
            $scheduledDate,
            (string) ($request->comments ?? ''),
            $executors
        );
        $this->sendTaskDispatchNotification($request, $data, $executors, $shouldSend);

        return $this->redirectToTaskList('任務已更新成功');
    }

    public function check(Request $request)
    {
        $task_templates = TaskTemplate::get();
        $datas = Task::query();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        // 日期篩選條件
        $estimated_date_start = $request->input('estimated_date_start');
        $estimated_date_end = $request->input('estimated_date_end');
        if ($estimated_date_start && $estimated_date_end) {
            $datas->whereBetween('estimated_end', [$estimated_date_start . ' 00:00:00', $estimated_date_end . ' 23:59:59']);
        } elseif ($estimated_date_start) {
            $datas->where('estimated_end', '>=', $estimated_date_start);
        } elseif ($estimated_date_end) {
            $datas->where('estimated_end', '<=', $estimated_date_end);
        }
        $user_id = $request->input('user_id');
        if ($user_id && $user_id !== "null") {
            $taskItemIds = TaskItem::where('user_id', $user_id)->pluck('task_id'); // 獲取符合條件的用戶 ID 列表
            $datas->whereIn('id', $taskItemIds); // 篩選出符合用戶 ID 的專案
        }


        // 排序優先級，然後按預計結束時間排序
        $datas = $datas->where('status', '8')
            ->with([
                'project_data.user_data',
                'task_template_data',
                'items.user_data',
                'user_data',
            ])
            ->orderBy('priority', 'asc')
            ->orderBy('estimated_end', 'asc')
            ->get();
        return view('task.check_index')->with('datas', $datas)->with('request', $request)->with('task_templates', $task_templates)->with('users', $users);
    }

    public function check_show($id)
    {
        $cust_projects = CustProject::get();
        $data = Task::with(['items.user_data', 'estimated_end_adjustments.creator', 'user_data', 'project_data.user_data'])
            ->where('id', $id)
            ->firstOrFail();
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $users = User::where('status', 1)->where('group_id', 1)->get();

        return view('task.check')->with('data', $data)->with('task_templates', $task_templates)->with('cust_projects', $cust_projects)->with('check_statuss', $check_statuss)->with('users', $users);
    }

    public function check_update($id, Request $request)
    {
        $data = Task::with('items')->findOrFail($id);
        $action = (string) $request->input('confirm_action', 'confirm');

        if ($action === 'adjust') {
            $request->validate([
                'adjusted_estimated_end_date' => 'required|date',
                'adjusted_estimated_end_time' => 'required|string',
                'adjustment_note' => 'required|string|max:2000',
            ], [
                'adjusted_estimated_end_date.required' => '請填寫須調整完的預計日期',
                'adjusted_estimated_end_time.required' => '請填寫須調整完的預計時間',
                'adjustment_note.required' => '請填寫調整說明',
            ]);

            $adjustedEnd = Carbon::parse(
                $request->input('adjusted_estimated_end_date').' '.$request->input('adjusted_estimated_end_time')
            )->format('Y-m-d H:i:s');

            TaskEstimatedEndAdjustment::create([
                'task_id' => $data->id,
                'adjusted_estimated_end' => $adjustedEnd,
                'previous_adjusted_estimated_end' => $data->adjusted_estimated_end,
                'note' => trim((string) $request->input('adjustment_note', '')) ?: null,
                'created_by' => Auth::id(),
            ]);

            // 不覆寫原本的 estimated_end（派工表訂完成）
            $data->adjusted_estimated_end = $adjustedEnd;
            $data->status = 7;
            $data->save();

            foreach ($data->items as $item) {
                $item->status = 7;
                $item->save();
            }

            $data->loadMissing(['items.user_data', 'task_template_data', 'project_data']);
            $this->sendTaskAdjustmentNotification(
                $data,
                $adjustedEnd,
                trim((string) $request->input('adjustment_note', '')) ?: null
            );

            $redirect = redirect()
                ->route('task.check.index')
                ->with('success', '已設為需調整，並留下調整紀錄');
            $warning = $this->dispatchNotification()->skippedWarningMessage();
            if ($warning !== null) {
                $redirect->with('warning', $warning);
            }

            return $redirect;
        }

        $data->status = 9;
        $data->actual_end = Carbon::now();
        $data->save();

        $items = TaskItem::where('task_id', $id)->get();
        foreach ($items as $item) {
            $item->status = 9;
            if (empty($item->end_time)) {
                $item->end_time = $data->actual_end;
            }
            $item->save();
        }

        $data->load('items');
        $this->syncMilestoneFormalDate($data);

        return redirect()->route('task.check.index')->with('success', '派工已確認完成');
    }

    public function ok(Request $request)
    {
        $task_templates = TaskTemplate::get();
        $datas = Task::query();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        // 日期篩選條件
        $estimated_date_start = $request->input('estimated_date_start');
        $estimated_date_end = $request->input('estimated_date_end');
        if ($estimated_date_start && $estimated_date_end) {
            $datas->whereBetween('estimated_end', [$estimated_date_start . ' 00:00:00', $estimated_date_end . ' 23:59:59']);
        } elseif ($estimated_date_start) {
            $datas->where('estimated_end', '>=', $estimated_date_start);
        } elseif ($estimated_date_end) {
            $datas->where('estimated_end', '<=', $estimated_date_end);
        }
        $user_id = $request->input('user_id');
        if ($user_id && $user_id !== "null") {
            $taskItemIds = TaskItem::where('user_id', $user_id)->pluck('task_id'); // 獲取符合條件的用戶 ID 列表
            $datas->whereIn('id', $taskItemIds); // 篩選出符合用戶 ID 的專案
        }


        // 排序優先級，然後按預計結束時間排序
        $datas = $datas->with(['project_data.user_data', 'task_template_data', 'items.user_data', 'user_data'])
            ->where('status', '9')
            ->orderBy('priority', 'asc')
            ->orderBy('estimated_end', 'asc')
            ->paginate(50)
            ->appends($request->query());
        return view('task.ok_index')->with('datas', $datas)->with('request', $request)->with('task_templates', $task_templates)->with('users', $users);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $cust_projects = CustProject::get();
        $data = Task::where('id', $id)->first();
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        return view('task.del')->with('data', $data)->with('task_templates', $task_templates)->with('cust_projects', $cust_projects)->with('check_statuss', $check_statuss)->with('users', $users);
    }

    public function destroy($id)
    {
        $data = Task::where('id', $id)->delete();
        $items = TaskItem::where('task_id', $id)->delete();
        return redirect()->route('task')->with('success', '任務已更新成功');
    }


    public function copy($id)
    {
        $cust_projects = CustProject::get();
        $data = Task::where('id', $id)->first();
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        return view('task.copy')->with('data', $data)->with('task_templates', $task_templates)->with('cust_projects', $cust_projects)->with('check_statuss', $check_statuss)->with('users', $users);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function copyData(Request $request, $id)
    {
        $this->dispatchNotification()->resetSkipped();

        $data = new Task;
        $data->type = 'group';
        $data->name = $request->name;
        $data->project_id = $request->project_id;
        $data->template_id = $request->template_id;
        $data->check_status_id = $request->check_status_id;
        $data->created_by = Auth::user()->id;
        $data->estimated_end = $request->estimated_end_date . ' ' . $request->estimated_end_time . ':00';
        $data->priority = $request->priority;
        $data->status = $request->status;
        $data->comments = $request->comments;
        $data->save();
        $this->syncMilestoneLinkedTask($data);

        $user_ids = $request->input('user_ids');
        $contexts = $request->input('contexts');

        // 抓取儲存後的 task_id
        $task_id = $data->id;
        foreach ($user_ids as $index => $user_id) {
            // 儲存資料到資料庫或其他操作
            TaskItem::create([
                'user_id' => $user_id,
                'context' => $contexts[$index],
                'task_id' => $task_id,  // 假設任務ID已存在
                'status' => '0',
                'start_time' => Carbon::now()->locale('zh-tw'),
            ]);
        }

        $executors = $this->buildExecutorsFromUserIds($user_ids);
        $this->sendTaskDispatchNotification($request, $data, $executors, true);

        return $this->redirectToTaskList('派工已複製');
    }
}
