<?php

namespace App\Http\Controllers;

use App\Models\LandingIndustryCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LandingIndustryCategoryController extends Controller
{
    protected function ensureCanManageLanding(): void
    {
        if (! in_array((int) (Auth::user()->level ?? 2), [0, 1], true)) {
            abort(403, '僅管理者可管理官網內容');
        }
    }

    protected function ensureCanDelete(): void
    {
        if (! in_array((int) (Auth::user()->level ?? 2), [0, 1], true)) {
            abort(403, '僅管理者可刪除官網內容');
        }
    }

    protected function wantsJson(Request $request): bool
    {
        return $request->expectsJson() || $request->ajax();
    }

    protected function itemPayload(LandingIndustryCategory $data): array
    {
        return [
            'id' => $data->id,
            'code' => (string) ($data->code ?? ''),
            'name' => (string) $data->name,
            'description' => (string) ($data->description ?? ''),
            'grid_columns' => (int) $data->grid_columns,
            'seq' => (int) $data->seq,
            'status' => (string) $data->status,
            'status_label' => $data->status === 'up' ? '啟用' : '停用',
            'brand_clients_count' => (int) ($data->brand_clients_count ?? $data->brandClients()->where('status', 'up')->count()),
            'clients_url' => route('landing.brand-clients', ['category_id' => $data->id]),
            'del_url' => route('landing.industry-categories.del', $data->id),
            'can_delete' => in_array((int) (Auth::user()->level ?? 2), [0, 1], true),
        ];
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

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $this->ensureCanManageLanding();

        $data = LandingIndustryCategory::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'grid_columns' => (int) $request->input('grid_columns', 6),
            'seq' => (int) $request->input('seq', 0),
            'status' => $request->input('status', 'up'),
        ]);
        $data->brand_clients_count = 0;

        if ($this->wantsJson($request)) {
            return response()->json([
                'success' => true,
                'message' => '產業類別已新增',
                'item' => $this->itemPayload($data),
            ]);
        }

        return redirect()->route('landing.industry-categories')->with('success', '產業類別已新增');
    }

    public function show($id): View
    {
        $this->ensureCanManageLanding();
        $data = LandingIndustryCategory::findOrFail($id);

        return view('landing_admin.industry_categories.edit', compact('data'));
    }

    public function update(Request $request, $id): RedirectResponse|JsonResponse
    {
        $this->ensureCanManageLanding();
        $data = LandingIndustryCategory::withCount(['brandClients' => fn ($q) => $q->where('status', 'up')])->findOrFail($id);
        $data->fill([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'grid_columns' => (int) $request->input('grid_columns', 6),
            'seq' => (int) $request->input('seq', 0),
            'status' => $request->input('status', 'up'),
        ]);
        $data->save();

        if ($this->wantsJson($request)) {
            return response()->json([
                'success' => true,
                'message' => '產業類別已更新',
                'item' => $this->itemPayload($data),
            ]);
        }

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
