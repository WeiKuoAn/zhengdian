<?php

namespace App\Http\Controllers;

use App\Models\LandingContentItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LandingContentItemController extends Controller
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

    protected function validateType(string $type): string
    {
        if (! array_key_exists($type, LandingContentItem::typeLabels())) {
            abort(404);
        }

        return $type;
    }

    public function index(Request $request): View
    {
        $this->ensureCanManageLanding();
        $type = $this->validateType((string) $request->input('type', 'stat'));
        $datas = LandingContentItem::query()
            ->where('type', $type)
            ->orderBy('seq')
            ->orderBy('id')
            ->get();

        return view('landing_admin.content_items.index', [
            'datas' => $datas,
            'type' => $type,
            'typeLabels' => LandingContentItem::typeLabels(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->ensureCanManageLanding();
        $type = $this->validateType((string) $request->input('type', 'stat'));

        return view('landing_admin.content_items.create', [
            'type' => $type,
            'typeLabels' => LandingContentItem::typeLabels(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureCanManageLanding();
        $type = $this->validateType((string) $request->input('type'));

        LandingContentItem::create([
            'type' => $type,
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'body' => $request->input('body'),
            'icon' => $request->input('icon'),
            'extra' => $request->input('extra'),
            'seq' => (int) $request->input('seq', 0),
            'status' => $request->input('status', 'up'),
        ]);

        return redirect()->route('landing.content-items', ['type' => $type])->with('success', '內容已新增');
    }

    public function show($id): View
    {
        $this->ensureCanManageLanding();
        $data = LandingContentItem::findOrFail($id);

        return view('landing_admin.content_items.edit', [
            'data' => $data,
            'typeLabels' => LandingContentItem::typeLabels(),
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->ensureCanManageLanding();
        $data = LandingContentItem::findOrFail($id);
        $data->fill([
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'body' => $request->input('body'),
            'icon' => $request->input('icon'),
            'extra' => $request->input('extra'),
            'seq' => (int) $request->input('seq', 0),
            'status' => $request->input('status', 'up'),
        ]);
        $data->save();

        return redirect()->route('landing.content-items', ['type' => $data->type])->with('success', '內容已更新');
    }

    public function delete($id): View
    {
        $this->ensureCanDelete();
        $data = LandingContentItem::findOrFail($id);

        return view('landing_admin.content_items.del', [
            'data' => $data,
            'typeLabels' => LandingContentItem::typeLabels(),
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $this->ensureCanDelete();
        $data = LandingContentItem::findOrFail($id);
        $type = $data->type;
        $data->delete();

        return redirect()->route('landing.content-items', ['type' => $type])->with('success', '內容已刪除');
    }
}
