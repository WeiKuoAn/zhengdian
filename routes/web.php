<?php

use App\Http\Controllers\RoutingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerProjectController;
use App\Http\Controllers\PresonCustomerController;
use App\Http\Controllers\PresonProjectController;
use App\Http\Controllers\ContractStatusController;
use App\Http\Controllers\CheckStatusController;
use App\Http\Controllers\TaskTemplateController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMilestonesController;
use App\Http\Controllers\MeetDataController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PersonTaskController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\CalendarCategoryController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProjectBusinessController;
use App\Http\Controllers\ProjectManufacturingController;
use App\Http\Controllers\SBIRController;
use App\Http\Controllers\SBIR2Controller;
use App\Http\Controllers\UserCustomerController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\SBIRFundController;
use App\Http\Controllers\DashboardController;
use App\Models\User; // ✅ 確保引用 Customer Model
use App\Http\Controllers\AjaxController;

require __DIR__ . '/auth.php';

// Route::get('', [RoutingController::class, 'index'])->name('landing');


// Route::get('/home', function () {
//     return view('index');
// })->middleware('auth')->name('home');

Route::get('home', [DashboardController::class, 'loginSuccess'])->name('index');

/**/
Route::get('/get-customer-account/{id}', [ProjectController::class, 'getCustomerAccount']);


/*用戶管理*/
Route::get('users', [UserController::class, 'index'])->name('users');
Route::get('user/create', [UserController::class, 'create'])->name('user.create');
Route::post('user/create', [UserController::class, 'store'])->name('user.create.data');
Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::post('user/edit/{id}', [UserController::class, 'update'])->name('user.edit.data');

/*客戶管理 */
Route::get('customers', [CustomerController::class, 'index'])->name('customers');
Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('customer/create', [CustomerController::class, 'store'])->name('customer.create.data');
Route::get('customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::post('customer/edit/{id}', [CustomerController::class, 'update'])->name('customer.edit.data');
Route::get('customer/del/{id}', [CustomerController::class, 'delete'])->name('customer.del');
Route::post('customer/del/{id}', [CustomerController::class, 'destroy'])->name('customer.del.data');

/*客戶專案管理 */
Route::get('customer/project/search', [AjaxController::class, 'project_search'])->name('customer.project.search');

// Route::get('customer/{id}/introduce-edit', [PresonCustomerController::class, 'IntroduceEdit'])->name('user.introduce.edit');
// Route::post('customer/{id}/introduce-edit', [PresonCustomerController::class, 'IntroduceUpdate'])->name('user.introduce.update');

Route::get('projects/{id}', [PresonProjectController::class, 'index'])->name('user.project.index');

/*專案狀態設定 */
Route::get('contractStatus', [ContractStatusController::class, 'index'])->name('contractStatus');
Route::get('contractStatus/create', [ContractStatusController::class, 'create'])->name('contractStatus.create');
Route::post('contractStatus/create', [ContractStatusController::class, 'store'])->name('contractStatus.create.data');
Route::get('contractStatus/edit/{id}', [ContractStatusController::class, 'show'])->name('contractStatus.edit');
Route::post('contractStatus/edit/{id}', [ContractStatusController::class, 'update'])->name('contractStatus.edit.data');
Route::get('contractStatus/del/{id}', [ContractStatusController::class, 'delete'])->name('contractStatus.del');
Route::post('contractStatus/del/{id}', [ContractStatusController::class, 'destroy'])->name('contractStatus.del.data');

/*專案狀態設定 */
Route::get('checkStatus', [CheckStatusController::class, 'index'])->name('checkStatus');
Route::get('checkStatus/create', [CheckStatusController::class, 'create'])->name('checkStatus.create');
Route::post('checkStatus/create', [CheckStatusController::class, 'store'])->name('checkStatus.create.data');
Route::get('checkStatus/edit/{id}', [CheckStatusController::class, 'show'])->name('checkStatus.edit');
Route::post('checkStatus/edit/{id}', [CheckStatusController::class, 'update'])->name('checkStatus.edit.data');
Route::get('checkStatus/del/{id}', [CheckStatusController::class, 'delete'])->name('checkStatus.del');
Route::post('checkStatus/del/{id}', [CheckStatusController::class, 'destroy'])->name('checkStatus.del.data');
Route::get('/get-parent-id', [CheckStatusController::class, 'getCheckStatus']);
Route::get('/get-child-id', [CheckStatusController::class, 'getCheckStatus_child_id']);

/*派工狀態設定 */
Route::get('TaskTemplate', [TaskTemplateController::class, 'index'])->name('TaskTemplate');
Route::get('TaskTemplate/create', [TaskTemplateController::class, 'create'])->name('TaskTemplate.create');
Route::post('TaskTemplate/create', [TaskTemplateController::class, 'store'])->name('TaskTemplate.create.data');
Route::get('TaskTemplate/edit/{id}', [TaskTemplateController::class, 'show'])->name('TaskTemplate.edit');
Route::post('TaskTemplate/edit/{id}', [TaskTemplateController::class, 'update'])->name('TaskTemplate.edit.data');
Route::get('TaskTemplate/del/{id}', [TaskTemplateController::class, 'delete'])->name('TaskTemplate.del');
Route::post('TaskTemplate/del/{id}', [TaskTemplateController::class, 'destroy'])->name('TaskTemplate.del.data');
Route::get('/get-tasktemplate-id', [TaskTemplateController::class, 'getTaskTemplate']);

/*派工狀態設定 */
Route::get('task', [TaskController::class, 'index'])->name('task');
Route::get('task/create', [TaskController::class, 'create'])->name('task.create');
Route::post('task/create', [TaskController::class, 'store'])->name('task.create.data');
Route::get('task/edit/{id}', [TaskController::class, 'show'])->name('task.edit');
Route::post('task/edit/{id}', [TaskController::class, 'update'])->name('task.edit.data');
Route::get('task/del/{id}', [TaskController::class, 'delete'])->name('task.del');
Route::post('task/del/{id}', [TaskController::class, 'destroy'])->name('task.del.data');
Route::get('task/copy/{id}', [TaskController::class, 'copy'])->name('task.copy');
Route::post('task/copy/{id}', [TaskController::class, 'copyData'])->name('task.copy.data');
Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
Route::get('task/check', [TaskController::class, 'check'])->name('task.check.index');
Route::get('task/check/{id}', [TaskController::class, 'check_show'])->name('task.check');
Route::post('task/check/{id}', [TaskController::class, 'check_update'])->name('task.check.data');
Route::get('task/ok', [TaskController::class, 'ok'])->name('task.ok.index');

/*專案類別設定 */
Route::get('projectType', [ProjectTypeController::class, 'index'])->name('projectTypes');
Route::get('projectType/create', [projectTypeController::class, 'create'])->name('projectType.create');
Route::post('projectType/create', [projectTypeController::class, 'store'])->name('projectType.create.data');
Route::get('projectType/edit/{id}', [projectTypeController::class, 'show'])->name('projectType.edit');
Route::post('projectType/edit/{id}', [projectTypeController::class, 'update'])->name('projectType.edit.data');
Route::get('projectType/del/{id}', [projectTypeController::class, 'delete'])->name('projectType.del');
Route::post('projectType/del/{id}', [projectTypeController::class, 'destroy'])->name('projectType.del.data');

Route::get('projects', [ProjectController::class, 'index'])->name('projects');
Route::get('project/create', [ProjectController::class, 'create'])->name('project.create');
Route::post('project/create', [ProjectController::class, 'store'])->name('project.create.data');
Route::get('project/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
Route::post('project/edit/{id}', [ProjectController::class, 'update'])->name('project.edit.data'); //01
Route::get('project/background/{id}', [ProjectController::class, 'background'])->name('project.background');
Route::post('project/background/{id}', [ProjectController::class, 'background_update'])->name('project.background.data');//02
Route::get('project/write/{id}', [ProjectController::class, 'write'])->name('project.write');
Route::post('project/write/{id}', [ProjectController::class, 'write_update'])->name('project.write.data');
Route::get('project/accounting/{id}', [ProjectController::class, 'accounting'])->name('project.accounting');
Route::post('project/accounting/{id}', [ProjectController::class, 'accounting_update'])->name('project.accounting.data');
Route::delete('/project/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

Route::get('project/send/{id}', [ProjectController::class, 'send'])->name('project.send');
Route::post('project/send/{id}', [ProjectController::class, 'send_update'])->name('project.send.data');   
Route::get('project/plan/{id}', [ProjectController::class, 'plan'])->name('project.plan');
Route::post('project/plan/{id}', [ProjectController::class, 'plan_update'])->name('project.plan.data');
Route::get('project/task/{id}', [ProjectController::class, 'task'])->name('project.task');
Route::post('project/task/{id}', [ProjectController::class, 'task_create'])->name('project.task.data');
Route::put('project/task/update/{id}', [ProjectController::class, 'task_update'])->name('project.task.update.data');
Route::delete('project/task/delete/{id}', [ProjectController::class, 'task_delete'])->name('project.task.delete.data');


//SBIR
Route::get('project/sbir01/{id}', [SBIRController::class, 'sbir01'])->name('project.sbir01');
Route::post('project/sbir01/{id}', [SBIRController::class, 'sbir01_data'])->name('project.sbir01.data');
Route::get('project/sbir02/{id}', [SBIRController::class, 'sbir02'])->name('project.sbir02');
Route::post('project/sbir02/{id}', [SBIRController::class, 'sbir02_data'])->name('project.sbir02.data');
Route::get('project/sbir03/{id}', [SBIRController::class, 'sbir03'])->name('project.sbir03');
Route::post('project/sbir03/{id}', [SBIRController::class, 'sbir03_data'])->name('project.sbir03.data');
Route::get('project/sbir04/{id}', [SBIRController::class, 'sbir04'])->name('project.sbir04');
Route::post('project/sbir04/{id}', [SBIRController::class, 'sbir04_data'])->name('project.sbir04.data');

//匯出初版計劃書
Route::get('project/sbir/{id}/exportWord', [SBIRController::class, 'exportWord'])->name('sbir.exportWord');

//SBIR05
Route::get('project/sbir05/{id}', [SBIRController::class, 'sbir05'])->name('project.sbir05');
Route::post('project/sbir05/{id}', [SBIRController::class, 'sbir05_data'])->name('project.sbir05.data');
Route::get('project/sbir05/{id}/export', [SBIRController::class, 'sbir05_export'])->name('project.sbir05.export');
Route::post('/project/{id}/sbir05/update-field', [SBIRController::class, 'sbir05_updateField']);
Route::get('/project/{id}/sbir05/get-field', function (\Illuminate\Http\Request $request, $id) {
    $field = $request->query('field');
    $record = \App\Models\SBIR05::where('project_id', $id)->first();
    return response()->json(['value' => $record?->{$field} ?? '']);
});

//SBIR06
Route::get('project/sbir06/{id}', [SBIRController::class, 'sbir06'])->name('project.sbir06');
Route::post('project/sbir06/{id}', [SBIRController::class, 'sbir06_data'])->name('project.sbir06.data');
Route::post('/project/{id}/sbir06/update-field', [SBIRController::class, 'sbir06_updateField']);
Route::get('/project/{id}/sbir06/get-field', function (\Illuminate\Http\Request $request, $id) {
    $field = $request->query('field');
    $record = \App\Models\SBIR06::where('project_id', $id)->first();
    return response()->json(['value' => $record?->{$field} ?? '']);
});

//SBIR07
Route::get('project/sbir07/{id}', [SBIRController::class, 'sbir07'])->name('project.sbir07');
Route::post('project/sbir07/{id}', [SBIRController::class, 'sbir07_data'])->name('project.sbir07.data');
Route::post('/project/{id}/sbir07/update-field', [SBIRController::class, 'sbir07_updateField']);
Route::get('/project/{id}/sbir07/get-field', function (\Illuminate\Http\Request $request, $id) {
    $field = $request->query('field');
    $record = \App\Models\SBIR07::where('project_id', $id)->first();
    return response()->json(['value' => $record?->{$field} ?? '']);
});

//SBIR08
Route::get('project/sbir08/{id}', [SBIRController::class, 'sbir08'])->name('project.sbir08');
Route::post('project/sbir08/{id}', [SBIRController::class, 'sbir08_data'])->name('project.sbir08.data');
Route::post('/project/{id}/sbir08/update-field', [SBIRController::class, 'sbir08_updateField']);
Route::get('/project/{id}/sbir08/get-field', function (\Illuminate\Http\Request $request, $id) {
    $field = $request->query('field');
    $record = \App\Models\SBIR08::where('project_id', $id)->first();
    return response()->json(['value' => $record?->{$field} ?? '']);
});

Route::get('project/sbir09/{id}', [SBIRController::class, 'sbir09'])->name('project.sbir09');
Route::post('project/sbir09/{id}', [SBIRController::class, 'sbir09_data'])->name('project.sbir09.data');
Route::get('project/sbir09/{id}/export', [SBIRController::class, 'sbir09_export'])->name('sbir09.export');

Route::get('project/sbir10/{id}', [SBIRController::class, 'sbir10'])->name('project.sbir10');
Route::post('project/sbir10/{id}', [SBIRController::class, 'sbir10_da'])->name('project.sbir10.data');


Route::get('project/sbir10/fund01/{id}', [SBIRFundController::class, 'fund01'])->name('project.fund01');
Route::post('project/sbir10/fund01/{id}', [SBIRFundController::class, 'fund01_data'])->name('project.fund01.data');
Route::get('project/sbir10/fund02/{id}', [SBIRFundController::class, 'fund02'])->name('project.fund02');
Route::post('project/sbir10/fund02/{id}', [SBIRFundController::class, 'fund02_data'])->name('project.fund02.data');
Route::get('project/sbir10/fund03/{id}', [SBIRFundController::class, 'fund03'])->name('project.fund03');
Route::post('project/sbir10/fund03/{id}', [SBIRFundController::class, 'fund03_data'])->name('project.fund03.data');
Route::get('project/sbir10/fund04/{id}', [SBIRFundController::class, 'fund04'])->name('project.fund04');
Route::post('project/sbir10/fund04/{id}', [SBIRFundController::class, 'fund04_data'])->name('project.fund04.data');
Route::get('project/sbir10/fund05/{id}', [SBIRFundController::class, 'fund05'])->name('project.fund05');
Route::post('project/sbir10/fund05/{id}', [SBIRFundController::class, 'fund05_data'])->name('project.fund05.data');
Route::get('project/sbir10/fund06/{id}', [SBIRFundController::class, 'fund06'])->name('project.fund06');
Route::post('project/sbir10/fund06/{id}', [SBIRFundController::class, 'fund06_data'])->name('project.fund06.data');
Route::get('project/sbir10/fund07/{id}', [SBIRFundController::class, 'fund07'])->name('project.fund07');
Route::post('project/sbir10/fund07/{id}', [SBIRFundController::class, 'fund07_data'])->name('project.fund07.data');
Route::get('project/sbir10/fund08/{id}', [SBIRFundController::class, 'fund08'])->name('project.fund08');
Route::post('project/sbir10/fund08/{id}', [SBIRFundController::class, 'fund08_data'])->name('project.fund08.data');
Route::get('project/sbir10/fund09/{id}', [SBIRFundController::class, 'fund09'])->name('project.fund09');
Route::post('project/sbir10/fund09/{id}', [SBIRFundController::class, 'fund09_data'])->name('project.fund09.data');
Route::get('project/sbir10/fund10/{id}', [SBIRFundController::class, 'fund10'])->name('project.fund10');
Route::post('project/sbir10/fund10/{id}', [SBIRFundController::class, 'fund10_data'])->name('project.fund10.data');
Route::get('project/sbir10/fund11/{id}', [SBIRFundController::class, 'fund11'])->name('project.fund11');
Route::post('project/sbir10/fund11/{id}', [SBIRFundController::class, 'fund11_data'])->name('project.fund11.data');
Route::get('project/sbir10/fund12/{id}', [SBIRFundController::class, 'fund12'])->name('project.fund12');
Route::post('project/sbir10/fund12/{id}', [SBIRFundController::class, 'fund12_data'])->name('project.fund12.data');
Route::get('project/sbir10/fund13/{id}', [SBIRFundController::class, 'fund13'])->name('project.fund13');
Route::post('project/sbir10/fund13/{id}', [SBIRFundController::class, 'fund13_data'])->name('project.fund13.data');

Route::get('project/sbir/{id}/export', [SBIRController::class, 'export'])->name('sbir.export');
Route::get('project/sbir08/{id}/export', [SBIRController::class, 'sbir08_export'])->name('sbir08.export');

Route::get('project/sbir/{id}/exportMerged', [SBIRController::class, 'exportMerged'])->name('sbir.exportMerged');
Route::get('sbir/{id}/export-motivation', [SBIR2Controller::class, 'exportResearchMotivation'])->name('sbir.export-motivation');

Route::get('project/sbir/appendix/{id}', [SBIRController::class, 'appendix'])->name('project.appendix');
Route::post('project/sbir/appendix/{id}', [SBIRController::class, 'appendixUpdate'])->name('project.appendix.update');
Route::get('project/sbir/supplement/{id}', [SBIRController::class, 'supplement'])->name('project.supplement');
Route::post('project/sbir/supplement/{id}', [SBIRController::class, 'supplement_data'])->name('project.supplement.data');


Route::post('/upload-image', [UploadController::class, 'uploadImage']);


Route::get('/api/task/{id}', [TaskController::class, 'getTaskDetails']);

Route::get('/get-customer-account/{id}', [ProjectController::class, 'getCustomerAccount']);

Route::get('project/midterm/{id}', [ProjectController::class, 'midterm'])->name('project.midterm');
// Route::get('project/midterm/{id}', [ProjectController::class, 'midterm_update'])->name('project.midterm.data');
Route::get('project/final/{id}', [ProjectController::class, 'final'])->name('project.final');
// Route::get('project/final/{id}', [ProjectController::class, 'final_update'])->name('project.final.data');
Route::get('project/meet/{id}', [ProjectController::class, 'meet'])->name('project.meet');
Route::get('project/meet/edit/{id}', [ProjectController::class, 'meet_edit'])->name('project.meet.edit');

// Route::get('project/meet/{id}', [ProjectController::class, 'meet_update'])->name('project.meet.data');

Route::get('/project/{id}', [ProjectController::class, 'show'])->name('project.show');

Route::get('projectMilestones', [ProjectMilestonesController::class, 'index'])->name('projectMilestones');
Route::get('projectMilestones/calendar', [ProjectMilestonesController::class, 'calendar'])->name('projectMilestones.calendar');
Route::get('projectMilestones/create', [ProjectMilestonesController::class, 'create'])->name('projectMilestones.create');
Route::post('projectMilestones/create', [ProjectMilestonesController::class, 'store'])->name('projectMilestones.create.data');
Route::get('projectMilestones/edit/{id}', [ProjectMilestonesController::class, 'show'])->name('projectMilestones.edit');
Route::post('projectMilestones/edit/{id}', [ProjectMilestonesController::class, 'update'])->name('projectMilestones.edit.data');
Route::get('/api/projectMilestones', [ProjectMilestonesController::class, 'projectMilestones']);


Route::get('meetData', [MeetDataController::class, 'index'])->name('meetDatas');
Route::get('meetData/create', [MeetDataController::class, 'create'])->name('meetData.create');
Route::post('meetData/create', [MeetDataController::class, 'store'])->name('meetData.create.data');
Route::get('meetData/edit/{id}', [MeetDataController::class, 'show'])->name('meetData.edit');
Route::post('meetData/edit/{id}', [MeetDataController::class, 'update'])->name('meetData.edit.data');
Route::get('meetData/del/{id}', [MeetDataController::class, 'delete'])->name('meetData.del');
Route::post('meetData/del/{id}', [MeetDataController::class, 'destroy'])->name('meetData.del.data');
Route::get('meetData/export/{id}', [MeetDataController::class, 'export'])->name('meetData.export');
Route::get('/meetData/exportWordWithHtml/{id}', [App\Http\Controllers\MeetDataController::class, 'exportWordWithHtml'])->name('meetData.exportWordWithHtml');


/*職稱管理*/
Route::get('/jobs', [JobController::class, 'index'])->middleware(['auth'])->name('jobs');
Route::get('/job/create', [JobController::class, 'create'])->name('job.create');
Route::post('/job/create', [JobController::class, 'store'])->name('job.create.data');
Route::get('/job/edit/{id}', [JobController::class, 'show'])->name('job.edit');
Route::post('/job/edit/{id}', [JobController::class, 'update'])->name('job.edit.data');

Route::get('/person/task', [PersonTaskController::class, 'index'])->middleware(['auth'])->name('person.task');
Route::get('/person/task/create', [PersonTaskController::class, 'create'])->name('person.task.create');
Route::post('/person/task/create', [PersonTaskController::class, 'store'])->name('person.task.create.data');
Route::get('/person/task/edit/{id}', [PersonTaskController::class, 'show'])->name('person.task.edit');
Route::post('/person/task/edit/{id}', [PersonTaskController::class, 'update'])->name('person.task.edit.data');
Route::get('/person/task/edit/{id}', [TaskController::class, 'edit']);
Route::get('/person/task/get-task-comments/{taskId}', [PersonTaskController::class, 'getTaskComments']);


//行事曆類別
Route::get('CalendarCategory', [CalendarCategoryController::class, 'index'])->name('CalendarCategorys');
Route::get('CalendarCategory/create', [CalendarCategoryController::class, 'create'])->name('CalendarCategory.create');
Route::post('CalendarCategory/create', [CalendarCategoryController::class, 'store'])->name('CalendarCategory.create.data');
Route::get('CalendarCategory/edit/{id}', [CalendarCategoryController::class, 'show'])->name('CalendarCategory.edit');
Route::post('CalendarCategory/edit/{id}', [CalendarCategoryController::class, 'update'])->name('CalendarCategory.edit.data');
Route::get('CalendarCategory/del/{id}', [CalendarCategoryController::class, 'delete'])->name('CalendarCategory.del');
Route::post('CalendarCategory/del/{id}', [CalendarCategoryController::class, 'destroy'])->name('CalendarCategory.del.data');

//行事曆
Route::get('/api/calendar/events', [CalendarController::class, 'getEvents']);
Route::post('/api/calendar/events', [CalendarController::class, 'storeOrUpdate']);
Route::delete('/api/calendar/events/{id}', [CalendarController::class, 'destroy']);

    
// routes/web.php
Route::get('/api/projects/{user_id}', [ProjectController::class, 'getProjectsByUser']);
Route::get('customer/introduce-create', [CustomerController::class, 'IntroduceCreate'])->name('cust.introduce.create');
Route::post('customer/introduce-create', [CustomerController::class, 'IntroduceStore'])->name('cust.introduce.store');

//客戶專案瀏覽
Route::get('customer/project', [CustomerProjectController::class, 'index'])->name('customer.project');
Route::get('customer/project/sbir/appendix/{encrypted_id}', [CustomerProjectController::class, 'sbir_appendix'])->name('customer.project.sbir.appendix');
Route::get('customer/project/supplement/{encrypted_id}', [CustomerProjectController::class, 'supplement'])->name('customer.project.supplement');
Route::post('customer/project/supplement/{encrypted_id}', [CustomerProjectController::class, 'supplement_store'])->name('customer.project.supplement.store');

//客戶會議瀏覽
Route::get('customer/meet', [CustomerProjectController::class, 'Meet'])->name('customer.meet');
Route::get('customer/meet/check/{encrypted_id}', [CustomerProjectController::class, 'MeetCheck'])->name('customer.meet.check');
Route::post('customer/meet/check/{encrypted_id}', [CustomerProjectController::class, 'MeetCheckData'])->name('customer.meet.check.data');

//客戶介面-專案
Route::get('business-create', [ProjectBusinessController::class, 'BusinessCreate'])->name('business.create');
Route::post('business-store', [ProjectBusinessController::class, 'BusinessStore'])->name('business.store');
Route::get('business-appendix', [ProjectBusinessController::class, 'BusinessAppendix'])->name('business.appendix');
Route::get('business-preview', [ProjectBusinessController::class, 'BusinessPreview'])->name('business.preview');

Route::post('/update-checkbox-status', [ProjectBusinessController::class, 'updateAppendixStatus'])->name('appendix-status');

//製造業畫面
Route::get('manufacturing-create', [ProjectManufacturingController::class, 'ManufacturingCreate'])->name('manufacturing.create');
Route::post('manufacturing-create', [ProjectManufacturingController::class, 'ManufacturingStore'])->name('manufacturing.store');
Route::get('manufacturing-preview', [ProjectManufacturingController::class, 'ManufacturingPreview'])->name('manufacturing.preview');
Route::get('manufacturing-appendix', [ProjectManufacturingController::class, 'ManufacturingAppendix'])->name('manufacturing.appendix');


Route::get('customer/{id}/introduce-edit', [UserCustomerController::class,'IntroduceEdit'])->name('user.introduce.edit');
Route::post('customer/{id}/introduce-edit', [UserCustomerController::class,'IntroduceUpdate'])->name('user.introduce.update');
Route::get('customer/{id}/project', [UserCustomerController::class,'index'])->name('admin.project.index');

Route::get('user-password', [UserController::class, 'password_show'])->name('user-password');
Route::post('user-password', [UserController::class, 'password_update'])->name('user-password.data');
    
Route::get('', function () {
    Auth::logout();
    return view('auth.login');
});
