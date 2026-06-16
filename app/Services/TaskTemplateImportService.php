<?php

namespace App\Services;

use App\Models\CheckStatus;
use App\Models\TaskTemplate;
use Illuminate\Support\Facades\Auth;

final class TaskTemplateImportService
{
    /**
     * @return array{created:int, updated:int, skipped:int, auto_created_statuses:list<string>, errors:list<string>}
     */
    public function importFromXlsx(string $path): array
    {
        $rows = SimpleXlsxReader::readFirstSheet($path);
        if ($rows === []) {
            return [
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'auto_created_statuses' => [],
                'errors' => ['Excel 檔案沒有資料'],
            ];
        }

        $map = $this->detectColumns($rows[0]);
        if ($map['name'] === null) {
            return [
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'auto_created_statuses' => [],
                'errors' => ['找不到「派工項目名稱」欄位，請使用系統範本格式'],
            ];
        }

        $parentsByName = CheckStatus::query()
            ->whereNull('parent_id')
            ->get()
            ->keyBy(fn (CheckStatus $row) => $this->normalizeKey($row->name));

        $childrenByName = CheckStatus::query()
            ->whereNotNull('parent_id')
            ->get()
            ->groupBy(fn (CheckStatus $row) => $this->normalizeKey($row->name));

        $result = [
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'auto_created_statuses' => [],
            'errors' => [],
        ];
        $seqByStage = [];

        foreach (array_slice($rows, 1) as $index => $row) {
            $lineNo = $index + 2;
            $name = $this->cell($row, $map['name']);
            if ($name === '') {
                continue;
            }

            $parentName = $this->cell($row, $map['parent']);
            $stageName = $this->cell($row, $map['stage']);
            $description = $this->cellRaw($row, $map['description']);
            $hoursRaw = $this->cell($row, $map['hours']);

            $resolved = $this->resolveStatusIds($parentName, $stageName, $parentsByName, $childrenByName, $result);
            if ($resolved['error'] !== null) {
                $result['errors'][] = '第 ' . $lineNo . ' 列：' . $resolved['error'];
                $result['skipped']++;
                continue;
            }

            $hours = $this->parseHours($hoursRaw);
            if ($hours === null) {
                $result['errors'][] = '第 ' . $lineNo . ' 列：執行時數格式不正確（' . $hoursRaw . '）';
                $result['skipped']++;
                continue;
            }

            $stageKey = ($resolved['check_status_id'] ?? 'null') . '|' . ($resolved['check_status_parent_id'] ?? 'null');
            $seqByStage[$stageKey] = ($seqByStage[$stageKey] ?? 0) + 1;

            $payload = [
                'check_status_parent_id' => $resolved['check_status_parent_id'],
                'check_status_id' => $resolved['check_status_id'],
                'description' => trim($description) !== '' ? $description : null,
                'duration_hours' => $hours,
                'seq' => (string) $seqByStage[$stageKey],
            ];

            $existing = TaskTemplate::query()->where('name', $name)->first();

            if ($existing !== null) {
                $existing->fill($payload);
                $existing->save();
                $result['updated']++;
                continue;
            }

            TaskTemplate::query()->create(array_merge($payload, [
                'name' => $name,
                'status' => 'up',
                'created_by' => Auth::id(),
            ]));
            $result['created']++;
        }

        return $result;
    }

    /**
     * @param list<string> $header
     * @return array{name:?int, parent:?int, stage:?int, description:?int, hours:?int}
     */
    protected function detectColumns(array $header): array
    {
        $map = [
            'name' => null,
            'parent' => null,
            'stage' => null,
            'description' => null,
            'hours' => null,
        ];

        foreach ($header as $index => $label) {
            $label = trim((string) $label);
            if ($label === '') {
                continue;
            }

            if ($map['name'] === null && (str_contains($label, '派工項目') || strcasecmp($label, 'name') === 0)) {
                $map['name'] = $index;
                continue;
            }
            if ($map['stage'] === null && str_contains($label, '專案階段')) {
                $map['stage'] = $index;
                continue;
            }
            if ($map['parent'] === null && str_contains($label, '專案狀態')) {
                $map['parent'] = $index;
                continue;
            }
            if ($map['description'] === null && str_contains($label, '描述')) {
                $map['description'] = $index;
                continue;
            }
            if ($map['hours'] === null && (str_contains($label, '執行時數') || str_contains($label, '時數'))) {
                $map['hours'] = $index;
            }
        }

        return $map;
    }

    /**
     * @param \Illuminate\Support\Collection<string, CheckStatus> $parentsByName
     * @param \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<int, CheckStatus>> $childrenByName
     * @return array{check_status_parent_id:?int, check_status_id:?int, error:?string}
     */
    protected function resolveStatusIds(
        string $parentName,
        string $stageName,
        $parentsByName,
        $childrenByName,
        array &$result
    ): array {
        $parentName = trim($parentName);
        $stageName = trim($stageName);

        if ($stageName !== '') {
            $stageMatches = $childrenByName->get($this->normalizeKey($stageName), collect());
            if ($stageMatches->isEmpty()) {
                return ['check_status_parent_id' => null, 'check_status_id' => null, 'error' => '找不到專案階段「' . $stageName . '」'];
            }

            if ($parentName !== '') {
                $parent = $parentsByName->get($this->normalizeKey($parentName));
                if ($parent === null) {
                    return ['check_status_parent_id' => null, 'check_status_id' => null, 'error' => '找不到專案狀態「' . $parentName . '」'];
                }
                $stage = $stageMatches->firstWhere('parent_id', $parent->id);
                if ($stage === null) {
                    return ['check_status_parent_id' => null, 'check_status_id' => null, 'error' => '專案階段「' . $stageName . '」不屬於專案狀態「' . $parentName . '」'];
                }

                return [
                    'check_status_parent_id' => (int) $parent->id,
                    'check_status_id' => (int) $stage->id,
                    'error' => null,
                ];
            }

            if ($stageMatches->count() > 1) {
                return ['check_status_parent_id' => null, 'check_status_id' => null, 'error' => '專案階段「' . $stageName . '」名稱重複，請在 Excel 加上「專案狀態」欄'];
            }

            $stage = $stageMatches->first();

            return [
                'check_status_parent_id' => (int) $stage->parent_id,
                'check_status_id' => (int) $stage->id,
                'error' => null,
            ];
        }

        if ($parentName === '') {
            return ['check_status_parent_id' => null, 'check_status_id' => null, 'error' => '缺少專案狀態或專案階段'];
        }

        $parent = $parentsByName->get($this->normalizeKey($parentName));
        if ($parent !== null) {
            return [
                'check_status_parent_id' => (int) $parent->id,
                'check_status_id' => null,
                'error' => null,
            ];
        }

        $childMatches = $childrenByName->get($this->normalizeKey($parentName), collect());
        if ($childMatches->isEmpty()) {
            $parent = CheckStatus::query()->create([
                'name' => $parentName,
                'status' => 'up',
                'seq' => '0',
            ]);
            $parentsByName->put($this->normalizeKey($parent->name), $parent);
            $label = '專案狀態「' . $parentName . '」';
            if (!in_array($label, $result['auto_created_statuses'], true)) {
                $result['auto_created_statuses'][] = $label;
            }

            return [
                'check_status_parent_id' => (int) $parent->id,
                'check_status_id' => null,
                'error' => null,
            ];
        }
        if ($childMatches->count() > 1) {
            return ['check_status_parent_id' => null, 'check_status_id' => null, 'error' => '「' . $parentName . '」對應多個專案階段，請新增「專案階段」欄位區分'];
        }

        $child = $childMatches->first();

        return [
            'check_status_parent_id' => (int) $child->parent_id,
            'check_status_id' => (int) $child->id,
            'error' => null,
        ];
    }

    protected function parseHours(string $raw): ?float
    {
        $raw = trim(str_replace(['小時', '時', ' '], '', $raw));
        if ($raw === '') {
            return 0.0;
        }
        if (!is_numeric($raw)) {
            return null;
        }

        return max(0, (float) $raw);
    }

    /** @param list<string> $row */
    protected function cellRaw(array $row, ?int $index): string
    {
        if ($index === null) {
            return '';
        }

        $value = (string) ($row[$index] ?? '');

        return preg_replace("/\r\n?/", "\n", $value) ?? $value;
    }

    /** @param list<string> $row */
    protected function cell(array $row, ?int $index): string
    {
        if ($index === null) {
            return '';
        }

        return trim((string) ($row[$index] ?? ''));
    }

    protected function normalizeKey(?string $value): string
    {
        return mb_strtolower(trim((string) $value));
    }
}
