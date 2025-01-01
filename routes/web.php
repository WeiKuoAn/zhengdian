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
Route::get('user/edit/{id}', [UserController::class, 'show'])->name('user.edit');
Route::post('user/edit/{id}', [UserController::class, 'update'])->name('user.edit.data');

/*客戶管理 */
Route::get('customers', [CustomerController::class, 'index'])->name('customers');
Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('customer/create', [CustomerController::class, 'store'])->name('customer.create.data');
Route::get('customer/edit/{id}', [CustomerController::class, 'show'])->name('customer.edit');
Route::post('customer/edit/{id}', [CustomerController::class, 'update'])->name('customer.edit.data');
Route::get('customer/del/{id}', [CustomerController::class, 'delete'])->name('customer.del');
Route::post('customer/del/{id}', [CustomerController::class, 'destroy'])->name('customer.del.data');

Route::get('customer/{id}/introduce-edit', [PresonCustomerController::class,'IntroduceEdit'])->name('user.introduce.edit');
Route::post('customer/{id}/introduce-edit', [PresonCustomerController::class,'IntroduceUpdate'])->name('user.introduce.update');

Route::get('projects/{id}', [PresonProjectController::class,'index'])->name('user.project.index');

/*簽約狀態設定 */
Route::get('contractStatus', [ContractStatusController::class, 'index'])->name('contractStatus');
Route::get('contractStatus/create', [ContractStatusController::class, 'create'])->name('contractStatus.create');
Route::post('contractStatus/create', [ContractStatusController::class, 'store'])->name('contractStatus.create.data');
Route::get('contractStatus/edit/{id}', [ContractStatusController::class, 'show'])->name('contractStatus.edit');
Route::post('contractStatus/edit/{id}', [ContractStatusController::class, 'update'])->name('contractStatus.edit.data');

/*計畫狀態設定 */
Route::get('checkStatus', [CheckStatusController::class, 'index'])->name('checkStatus');
Route::get('checkStatus/create', [CheckStatusController::class, 'create'])->name('checkStatus.create');
Route::post('checkStatus/create', [CheckStatusController::class, 'store'])->name('checkStatus.create.data');
Route::get('checkStatus/edit/{id}', [CheckStatusController::class, 'show'])->name('checkStatus.edit');
Route::post('checkStatus/edit/{id}', [CheckStatusController::class, 'update'])->name('checkStatus.edit.data');

Route::get('', function () {
    Auth::logout();
    return view('auth.login');
});
