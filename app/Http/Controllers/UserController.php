<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\Job;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groups = UserGroup::whereNotIn('id', [2])->get();
        $statusFilter = $request->input('status_filter', 'enabled');

        $datasQuery = User::whereNotIn('group_id', [2]);
        if ($statusFilter === 'enabled') {
            $datasQuery->where(function ($q) {
                $q->where('status', '0')
                  ->orWhereNull('status');
            });
        } elseif ($statusFilter === 'disabled') {
            $datasQuery->whereNotNull('status')->where('status', '!=', '0');
        }

        $datas = $datasQuery->orderby('level', 'asc')->get();

        return view('user.index')
            ->with('datas', $datas)
            ->with('groups', $groups)
            ->with('statusFilter', $statusFilter);
    }

    public function groups()
    {
        $datas = UserGroup::whereNotIn('id', [2])->orderBy('id', 'asc')->get();
        return view('user.groups')->with('datas', $datas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobs = Job::where('status', 'up')->get();
        $groups = UserGroup::whereNotIn('id', [2])->get();
        return view('user.create')->with('groups', $groups)->with('jobs', $jobs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 创建用户
        $user = User::create([
            'name' => $request->name,
            'synology_user_id' => $request->synology_user_id,
            'email' => $request->email,
            'job_id' => $request->job_id,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'group_id' => $request->group_id,
        ]);

        
        $user_data = User::orderby('id','desc')->first();
        // dd($user_data);
        // 创建 Job 并关联 user_id
        // $job = new Job;
        // $job->user_id = $user_data->id; // 从 $user 对象中获取 user_id
        // $job->job_id = $request->job_id;
        // $job->save();


        return redirect()->route('users');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    public function password_show()
    {
        return view('person.edit-password')->with('hint', '0');
    }

    public function password_update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (Hash::check($request->password, $user->password)) {
            if ($request->password_new === $request->password_conf) {
                // 更新密碼
                $user->password = Hash::make($request->password_new);
                $user->save();

                // 登出用戶
                Auth::logout();

                // 重導向至首頁
                return redirect('/');
            } else {
                // 新密碼與確認密碼不符
                return view('person.edit-password')->with(['hint' => '2']);
            }
        } else {
            // 舊密碼不正確
            return view('person.edit-password')->with(['hint' => '1']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $groups = UserGroup::whereNotIn('id', [2])->get();
        $jobs = Job::where('status', 'up')->get();
        $data = User::where('id', $id)->first();
        return view('user.edit')->with('data', $data)->with('groups', $groups)->with('jobs', $jobs);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = User::where('id', $id)->first();
        $data->name = $request->name;
        $data->level = $request->level;
        $data->group_id = $request->group_id;
        $data->job_id = $request->job_id;
        $data->status = $request->status;
        $data->synology_user_id = $request->synology_user_id;
        $data->save();
        return redirect()->route('users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $currentUser = Auth::user();
        if ((int) ($currentUser->level ?? -1) !== 0) {
            abort(403, '只有超級管理者可以刪除帳號');
        }

        if ((int) $currentUser->id === (int) $id) {
            return redirect()->route('users')->with('error', '不可刪除目前登入中的帳號');
        }

        $targetUser = User::findOrFail($id);
        if ((int) ($targetUser->level ?? -1) === 0) {
            return redirect()->route('users')->with('error', '不可刪除超級管理者帳號');
        }

        $targetUser->delete();

        return redirect()->route('users')->with('success', '帳號已刪除');
    }
}
