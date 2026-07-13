<?php

namespace App\Http\Controllers;

use App\Models\LandingIndustryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LandingIndustryCategoryController extends Controller
{
    protected function ensureCanManageLanding(): void
    {
        if ((int) (Auth::user()->level ?? 2) === 2) {
            abort(403, '一般使用者無法管理官網內容');
        }
    }

    protected function ensureCanDelete(): void
    {
        if ((int) (Auth::user()->level ?? 2) === 2) {
            abort(403, '一般使用者無法刪除設定資料');
        }
    }

    public function index(): View
    {
        $this->ensureCanManageLanding();
        $datas = LandingIndustryCategory::query()
            ->withCount(['brandClients' => fn ($q) => $q->where('status', 'up')])
            ->orderBy('seq')
            ->orderBy('id')
            ->get();

        return view('landing_admin.industry_categories.index', compact('datas'));
    }

    public function create(): View
    {
        $this->ensureCanManageLanding();

        return view('landing_admin.industry_categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureCanManageLanding();

        LandingIndustryCategory::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'grid_columns' => (int) $request->input('grid_columns', 6),
            'seq' => (int) $request->input('seq', 0),
            'status' => $request->input('status', 'up'),
        ]);

        return redirect()->route('landing.industry-categories')->with('success', '產業類別已新增');
    }

    public function show($id): View
    {
        $this->ensureCanManageLanding();
        $data = LandingIndustryCategory::findOrFail($id);

        return view('landing_admin.industry_categories.edit', compact('data'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->ensureCanManageLanding();
        $data = LandingIndustryCategory::findOrFail($id);
        $data->fill([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'grid_columns' => (int) $request->input('grid_columns', 6),
            'seq' => (int) $request->input('seq', 0),
            'status' => $request->input('status', 'up'),
        ]);
        $data->save();

        return redirect()->route('landing.industry-categories')->with('success', '產業類別已更新');
    }

    public function delete($id): View
    {
        $this->ensureCanDelete();
        $data = LandingIndustryCategory::findOrFail($id);

        return view('landing_admin.industry_categories.del', compact('data'));
    }

    public function destroy($id): RedirectResponse
    {
        $this->ensureCanDelete();
        $data = LandingIndustryCategory::findOrFail($id);
        $data->brandClients()->delete();
        $data->delete();

        return redirect()->route('landing.industry-categories')->with('success', '產業類別已刪除');
    }
}
