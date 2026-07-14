<?php

namespace App\Http\Controllers;

use App\Models\LandingContentItem;
use App\Support\LandingSectionRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

    protected function itemPayload(LandingContentItem $data, ?string $section = null): array
    {
        $section = LandingSectionRegistry::normalizeKey(
            $section ?: LandingSectionRegistry::sectionForContentType($data->type)
        );

        $sub = trim((string) ($data->subtitle ?: $data->icon));
        if ($data->extra) {
            $sub = $sub === '' ? (string) $data->extra : $sub.' / '.$data->extra;
        }

        return [
            'id' => $data->id,
            'type' => $data->type,
            'typeLabel' => LandingContentItem::typeLabels()[$data->type] ?? $data->type,
            'title' => (string) $data->title,
            'subtitle' => (string) ($data->subtitle ?? ''),
            'icon' => (string) ($data->icon ?? ''),
            'extra' => (string) ($data->extra ?? ''),
            'body' => (string) ($data->body ?? ''),
            'seq' => (int) $data->seq,
            'status' => (string) $data->status,
            'sub_display' => $sub,
            'body_preview' => Str::limit((string) $data->body, 48),
            'status_up' => $data->status === 'up',
            'del_url' => route('landing.content-items.del', ['id' => $data->id, 'section' => $section]),
            'can_delete' => in_array((int) (Auth::user()->level ?? 2), [0, 1], true),
        ];
    }

    protected function wantsJson(Request $request): bool
    {
        return $request->expectsJson() || $request->ajax();
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

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $this->ensureCanManageLanding();
        $type = $this->validateType((string) $request->input('type'));

        $data = LandingContentItem::create([
            'type' => $type,
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'body' => $request->input('body'),
            'icon' => $request->input('icon'),
            'extra' => $request->input('extra'),
            'seq' => (int) $request->input('seq', 0),
            'status' => $request->input('status', 'up'),
        ]);

        if ($this->wantsJson($request)) {
            return response()->json([
                'success' => true,
                'message' => '內容已新增',
                'item' => $this->itemPayload($data, (string) $request->input('section')),
            ]);
        }

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

    public function update(Request $request, $id): RedirectResponse|JsonResponse
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

        if ($this->wantsJson($request)) {
            return response()->json([
                'success' => true,
                'message' => '內容已更新',
                'item' => $this->itemPayload($data, (string) $request->input('section')),
            ]);
        }

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
