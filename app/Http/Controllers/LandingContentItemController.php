<?php

namespace App\Http\Controllers;

use App\Models\LandingContentItem;
use App\Support\LandingSectionRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LandingContentItemController extends Controller
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

    protected function validateType(string $type): string
    {
        if (! array_key_exists($type, LandingContentItem::typeLabels())) {
            abort(404);
        }

        return $type;
    }

    protected function sectionReturnUrl(?string $type = null, ?string $section = null): string
    {
        $section = $section ?: ($type ? LandingSectionRegistry::sectionForContentType($type) : LandingSectionRegistry::defaultKey());

        return route('landing.sections', ['section' => $section]);
    }

    public function index(Request $request)
    {
        return redirect()->to($this->sectionReturnUrl(
            (string) $request->input('type', 'stat'),
            (string) $request->input('section', '')
        ));
    }

    public function create(Request $request): View
    {
        $this->ensureCanManageLanding();
        $type = $this->validateType((string) $request->input('type', 'stat'));
        $sectionKey = LandingSectionRegistry::normalizeKey(
            (string) $request->input('section', LandingSectionRegistry::sectionForContentType($type))
        );

        return view('landing_admin.content_items.create', [
            'type' => $type,
            'sectionKey' => $sectionKey,
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

        return redirect()->to($this->sectionReturnUrl($type, (string) $request->input('section')))
            ->with('success', '內容已新增');
    }

    public function show(Request $request, $id): View
    {
        $this->ensureCanManageLanding();
        $data = LandingContentItem::findOrFail($id);
        $sectionKey = LandingSectionRegistry::normalizeKey(
            (string) $request->input('section', LandingSectionRegistry::sectionForContentType($data->type))
        );

        return view('landing_admin.content_items.edit', [
            'data' => $data,
            'sectionKey' => $sectionKey,
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

        return redirect()->to($this->sectionReturnUrl($data->type, (string) $request->input('section')))
            ->with('success', '內容已更新');
    }

    public function delete(Request $request, $id): View
    {
        $this->ensureCanDelete();
        $data = LandingContentItem::findOrFail($id);
        $sectionKey = LandingSectionRegistry::normalizeKey(
            (string) $request->input('section', LandingSectionRegistry::sectionForContentType($data->type))
        );

        return view('landing_admin.content_items.del', [
            'data' => $data,
            'sectionKey' => $sectionKey,
            'typeLabels' => LandingContentItem::typeLabels(),
        ]);
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $this->ensureCanDelete();
        $data = LandingContentItem::findOrFail($id);
        $type = $data->type;
        $data->delete();

        return redirect()->to($this->sectionReturnUrl($type, (string) $request->input('section')))
            ->with('success', '內容已刪除');
    }
}
