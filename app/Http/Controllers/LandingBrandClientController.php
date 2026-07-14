<?php

namespace App\Http\Controllers;

use App\Models\LandingBrandClient;
use App\Models\LandingIndustryCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LandingBrandClientController extends Controller
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

    protected function itemPayload(LandingBrandClient $data): array
    {
        $data->loadMissing('category');

        return [
            'id' => $data->id,
            'category_id' => $data->category_id,
            'category_name' => $data->category->name ?? '—',
            'name' => (string) $data->name,
            'seq' => (int) $data->seq,
            'status' => (string) $data->status,
            'status_label' => $data->status === 'up' ? '啟用' : '停用',
            'logo_url' => $data->logoUrl(),
            'del_url' => route('landing.brand-clients.del', $data->id),
            'can_delete' => in_array((int) (Auth::user()->level ?? 2), [0, 1], true),
        ];
    }

    public function index(Request $request): View
    {
        $this->ensureCanManageLanding();
        $categoryId = $request->input('category_id');
        $categories = LandingIndustryCategory::query()->orderBy('seq')->orderBy('id')->get();

        $query = LandingBrandClient::query()->with('category')->orderBy('seq')->orderBy('id');
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        $datas = $query->get();

        return view('landing_admin.brand_clients.index', compact('datas', 'categories', 'categoryId'));
    }

    public function create(Request $request): View
    {
        $this->ensureCanManageLanding();
        $categories = LandingIndustryCategory::query()->orderBy('seq')->orderBy('id')->get();

        return view('landing_admin.brand_clients.create', [
            'categories' => $categories,
            'defaultCategoryId' => $request->input('category_id'),
        ]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $this->ensureCanManageLanding();

        $data = new LandingBrandClient([
            'category_id' => (int) $request->input('category_id'),
            'name' => $request->input('name'),
            'seq' => (int) $request->input('seq', 0),
            'status' => $request->input('status', 'up'),
        ]);

        if ($request->hasFile('logo')) {
            $data->logo_path = $request->file('logo')->store('landing/brands', 'public');
        }

        $data->save();

        if ($this->wantsJson($request)) {
            return response()->json([
                'success' => true,
                'message' => '合作客戶已新增',
                'item' => $this->itemPayload($data),
            ]);
        }

        return redirect()->route('landing.brand-clients', ['category_id' => $data->category_id])
            ->with('success', '合作客戶已新增');
    }

    public function show($id): View
    {
        $this->ensureCanManageLanding();
        $data = LandingBrandClient::with('category')->findOrFail($id);
        $categories = LandingIndustryCategory::query()->orderBy('seq')->orderBy('id')->get();

        return view('landing_admin.brand_clients.edit', compact('data', 'categories'));
    }

    public function update(Request $request, $id): RedirectResponse|JsonResponse
    {
        $this->ensureCanManageLanding();
        $data = LandingBrandClient::findOrFail($id);

        $data->fill([
            'category_id' => (int) $request->input('category_id'),
            'name' => $request->input('name'),
            'seq' => (int) $request->input('seq', 0),
            'status' => $request->input('status', 'up'),
        ]);

        if ($request->hasFile('logo')) {
            if (! empty($data->logo_path)) {
                Storage::disk('public')->delete($data->logo_path);
            }
            $data->logo_path = $request->file('logo')->store('landing/brands', 'public');
        }

        if ($request->boolean('remove_logo') && ! empty($data->logo_path)) {
            Storage::disk('public')->delete($data->logo_path);
            $data->logo_path = null;
        }

        $data->save();

        if ($this->wantsJson($request)) {
            return response()->json([
                'success' => true,
                'message' => '合作客戶已更新',
                'item' => $this->itemPayload($data),
            ]);
        }

        return redirect()->route('landing.brand-clients', ['category_id' => $data->category_id])
            ->with('success', '合作客戶已更新');
    }

    public function delete($id): View
    {
        $this->ensureCanDelete();
        $data = LandingBrandClient::with('category')->findOrFail($id);

        return view('landing_admin.brand_clients.del', compact('data'));
    }

    public function destroy($id): RedirectResponse
    {
        $this->ensureCanDelete();
        $data = LandingBrandClient::findOrFail($id);
        $categoryId = $data->category_id;

        if (! empty($data->logo_path)) {
            Storage::disk('public')->delete($data->logo_path);
        }

        $data->delete();

        return redirect()->route('landing.brand-clients', ['category_id' => $categoryId])
            ->with('success', '合作客戶已刪除');
    }
}
