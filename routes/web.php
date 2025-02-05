<?php

use App\Http\Controllers\RoutingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
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
use App\Http\Controllers\UserCustomerController;

require __DIR__ . '/auth.php';

// Route::get('', [RoutingController::class, 'index'])->name('landing');

Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    // Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    // Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    // Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});

Route::get('/home', function () {
    return view('index');
})->middleware('auth')->name('home');


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

Route::get('customer/{id}/introduce-edit', [PresonCustomerController::class, 'IntroduceEdit'])->name('user.introduce.edit');
Route::post('customer/{id}/introduce-edit', [PresonCustomerController::class, 'IntroduceUpdate'])->name('user.introduce.update');

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

/*專案狀態設定 */
Route::get('TaskTemplate', [TaskTemplateController::class, 'index'])->name('TaskTemplate');
Route::get('TaskTemplate/create', [TaskTemplateController::class, 'create'])->name('TaskTemplate.create');
Route::post('TaskTemplate/create', [TaskTemplateController::class, 'store'])->name('TaskTemplate.create.data');
Route::get('TaskTemplate/edit/{id}', [TaskTemplateController::class, 'show'])->name('TaskTemplate.edit');
Route::post('TaskTemplate/edit/{id}', [TaskTemplateController::class, 'update'])->name('TaskTemplate.edit.data');
Route::get('TaskTemplate/del/{id}', [TaskTemplateController::class, 'delete'])->name('TaskTemplate.del');
Route::post('TaskTemplate/del/{id}', [TaskTemplateController::class, 'destroy'])->name('TaskTemplate.del.data');
Route::get('/get-tasktemplate-id', [TaskTemplateController::class, 'getTaskTemplate']);

/*專案狀態設定 */
Route::get('task', [TaskController::class, 'index'])->name('task');
Route::get('task/create', [TaskController::class, 'create'])->name('task.create');
Route::post('task/create', [TaskController::class, 'store'])->name('task.create.data');
Route::get('task/edit/{id}', [TaskController::class, 'show'])->name('task.edit');
Route::post('task/edit/{id}', [TaskController::class, 'update'])->name('task.edit.data');
Route::get('task/del/{id}', [TaskController::class, 'delete'])->name('task.del');
Route::post('task/del/{id}', [TaskController::class, 'destroy'])->name('task.del.data');
Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
Route::get('task/check', [TaskController::class, 'check'])->name('task.check.index');
Route::get('task/check/{id}', [TaskController::class, 'check_show'])->name('task.check');
Route::post('task/check/{id}', [TaskController::class, 'check_update'])->name('task.check.data');



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

Route::get('project/send/{id}', [ProjectController::class, 'send'])->name('project.send');
// Route::get('project/send/{id}', [ProjectController::class, 'send_update'])->name('project.send.data');
Route::get('project/plan/{id}', [ProjectController::class, 'plan'])->name('project.plan');
Route::post('project/plan/{id}', [ProjectController::class, 'plan_update'])->name('project.plan.data');
Route::get('project/task/{id}', [ProjectController::class, 'task'])->name('project.task');
Route::post('project/task/{id}', [ProjectController::class, 'task_create'])->name('project.task.data');
Route::put('project/task/update/{id}', [ProjectController::class, 'task_update'])->name('project.task.update.data');
Route::delete('project/task/delete/{id}', [ProjectController::class, 'task_delete'])->name('project.task.delete.data');
Route::get('/api/task/{id}', [TaskController::class, 'getTaskDetails']);


Route::get('project/midterm/{id}', [ProjectController::class, 'midterm'])->name('project.midterm');
// Route::get('project/midterm/{id}', [ProjectController::class, 'midterm_update'])->name('project.midterm.data');
Route::get('project/final/{id}', [ProjectController::class, 'final'])->name('project.final');
// Route::get('project/final/{id}', [ProjectController::class, 'final_update'])->name('project.final.data');
Route::get('project/meet/{id}', [ProjectController::class, 'meet'])->name('project.meet');
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
    
Route::get('', function () {
    Auth::logout();
    return view('auth.login');
});
