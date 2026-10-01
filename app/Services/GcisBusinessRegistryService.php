<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GcisBusinessRegistryService
{
    /**
     * 依統編查詢：先公司登記，再商業登記。
     *
     * @return array{
     *     tax_id: string,
     *     found: bool,
     *     registry_type: ?string,
     *     source: string,
     *     source_note: string,
     *     company: ?array<string, mixed>,
     *     business: ?array<string, mixed>,
     *     directors: array<int, array<string, mixed>>,
     *     branches: array<int, array<string, mixed>>,
     *     business_items: array<int, array<string, mixed>>,
     *     types: array<int, array{year?: string, exist: string, type: string}>,
     *     message: string,
     *     errors: array<int, string>
     * }
     */
    public function lookupByTaxId(string $taxId, bool $withDelay = true): array
    {
        $taxId = $this->normalizeTaxId($taxId);

        $result = [
            'tax_id' => $taxId,
            'found' => false,
            'registry_type' => null,
            'source' => 'gcis',
            'source_note' => '資料來源：經濟部商工行政資料開放平臺（公司登記基本資料-應用一／商業登記基本資料-應用三）。',
            'company' => null,
            'business' => null,
            'directors' => [],
            'branches' => [],
            'business_items' => [],
            'types' => [],
            'message' => '',
            'errors' => [],
        ];

        if (! preg_match('/^\d{8}$/', $taxId)) {
            $result['message'] = '統一編號須為 8 位數字（已嘗試補零）。';
            $result['errors'][] = $result['message'];

            return $result;
        }

        try {
            if ($withDelay) {
                $this->throttle();
            }
            $companyRows = $this->fetchCompany($taxId);
            if ($companyRows !== []) {
                $result['found'] = true;
                $result['registry_type'] = '公司';
                $result['company'] = $this->normalizeCompanyRow($companyRows[0]);
                $result['types'] = [['exist' => 'Y', 'type' => '公司', 'year' => '']];
                $result['message'] = '已從公司登記查得資料。';

                return $result;
            }

            if ($withDelay) {
                $this->throttle();
            }
            $businessRows = $this->fetchBusiness($taxId);
            if ($businessRows !== []) {
                $result['found'] = true;
                $result['registry_type'] = '商業';
                $result['business'] = $this->normalizeBusinessRow($businessRows[0]);
                $result['business_items'] = $result['business']['items'] ?? [];
                $result['types'] = [['exist' => 'Y', 'type' => '商業', 'year' => '']];
                $result['message'] = '已從商業登記查得資料。';

                return $result;
            }

            $result['message'] = '查無資料，請確認統編';
            $result['errors'][] = $result['message'];
        } catch (Throwable $e) {
            $msg = $this->friendlyError($e);
            $result['message'] = $msg;
            $result['errors'][] = $msg;
        }

        return $result;
    }

    /**
     * Excel 批次查詢（欄位：公司名稱、統一編號）。
     *
     * @return array{
     *     rows: list<array<string, mixed>>,
     *     summary: array{total:int, found:int, missing:int, errors:int},
     *     errors: list<string>
     * }
     */
    public function lookupFromExcel(string $xlsxPath): array
    {
        $sheet = SimpleXlsxReader::readFirstSheet($xlsxPath);
        if ($sheet === []) {
            return [
                'rows' => [],
                'summary' => ['total' => 0, 'found' => 0, 'missing' => 0, 'errors' => 0],
                'errors' => ['Excel 沒有資料'],
            ];
        }

        $map = $this->detectExcelColumns($sheet[0]);
        if ($map['tax_id'] === null) {
            return [
                'rows' => [],
                'summary' => ['total' => 0, 'found' => 0, 'missing' => 0, 'errors' => 0],
                'errors' => ['找不到「統一編號」欄位，請確認表頭包含「統一編號」或「統編」'],
            ];
        }

        $max = max(1, (int) config('gcis.batch_max_rows', 200));
        $rows = [];
        $summary = ['total' => 0, 'found' => 0, 'missing' => 0, 'errors' => 0];
        $errors = [];

        $startIndex = $map['has_header'] ? 1 : 0;
        $dataRows = array_slice($sheet, $startIndex);

        foreach ($dataRows as $index => $row) {
            if ($summary['total'] >= $max) {
                $errors[] = '已達批次上限 '.$max.' 筆，其餘略過。';
                break;
            }

            $lineNo = $startIndex + $index + 1;
            $inputName = $map['name'] !== null ? trim((string) ($row[$map['name']] ?? '')) : '';
            $rawTax = trim((string) ($row[$map['tax_id']] ?? ''));
            if ($inputName === '' && $rawTax === '') {
                continue;
            }

            $summary['total']++;
            $normalized = $this->normalizeTaxId($rawTax);
            $lookup = $this->lookupByTaxId($normalized, true);

            $status = '查無資料，請確認統編';
            $registryType = '';
            $officialName = '';
            $responsible = '';
            $address = '';
            $companyStatus = '';
            $caseStatus = '';
            $orgType = '';
            $agency = '';

            if ($lookup['found'] && $lookup['company'] !== null) {
                $status = '公司登記';
                $registryType = '公司';
                $officialName = (string) ($lookup['company']['name'] ?? '');
                $responsible = (string) ($lookup['company']['responsible_name'] ?? '');
                $address = (string) ($lookup['company']['location'] ?? '');
                $companyStatus = (string) ($lookup['company']['status'] ?? '');
                $caseStatus = (string) ($lookup['company']['case_status'] ?? '');
                $summary['found']++;
            } elseif ($lookup['found'] && $lookup['business'] !== null) {
                $status = '商業登記';
                $registryType = '商業';
                $officialName = (string) ($lookup['business']['name'] ?? '');
                $address = (string) ($lookup['business']['address'] ?? '');
                $companyStatus = (string) ($lookup['business']['status'] ?? '');
                $orgType = (string) ($lookup['business']['org_type'] ?? '');
                $agency = (string) ($lookup['business']['agency'] ?? '');
                $summary['found']++;
            } elseif ($lookup['errors'] !== []) {
                $status = implode('；', $lookup['errors']);
                $summary['errors']++;
            } else {
                $summary['missing']++;
            }

            $nameMatch = null;
            if ($inputName !== '' && $officialName !== '') {
                $nameMatch = $this->namesLikelyMatch($inputName, $officialName);
            }

            $rows[] = [
                'line' => $lineNo,
                'input_name' => $inputName,
                'input_tax_id' => $rawTax,
                'tax_id' => $normalized,
                'status' => $status,
                'registry_type' => $registryType,
                'official_name' => $officialName,
                'name_match' => $nameMatch,
                'responsible' => $responsible,
                'address' => $address,
                'company_status' => $companyStatus,
                'case_status' => $caseStatus,
                'org_type' => $orgType,
                'agency' => $agency,
            ];
        }

        return compact('rows', 'summary', 'errors');
    }

    /**
     * 將統編正規化為 8 碼（去非數字、左側補零）。
     */
    public function normalizeTaxId(string $taxId): string
    {
        $digits = preg_replace('/\D+/', '', trim($taxId)) ?? '';
        if ($digits === '') {
            return '';
        }
        // Excel 可能吃掉前導 0，或變成科學記號整數字串
        if (strlen($digits) > 8) {
            // 若超長，取右側 8 碼較不合理；保留原數字讓後續驗證失敗較安全
            return $digits;
        }

        return str_pad($digits, 8, '0', STR_PAD_LEFT);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function fetchCompany(string $taxId): array
    {
        return $this->getJson(
            (string) config('gcis.endpoints.company_basic'),
            "Business_Accounting_NO eq '{$taxId}'"
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function fetchBusiness(string $taxId): array
    {
        return $this->getJson(
            (string) config('gcis.endpoints.business_basic'),
            "President_No eq '{$taxId}'"
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function getJson(string $endpointId, string $filter): array
    {
        $base = rtrim((string) config('gcis.base_url'), '/');
        $url = $base.'/'.$endpointId;

        $response = Http::timeout((int) config('gcis.timeout', 20))
            ->withHeaders([
                'User-Agent' => 'ZhengdianInternalGcisLookup/1.0',
                'Accept' => 'application/json',
            ])
            ->get($url, [
                '$format' => 'json',
                '$filter' => $filter,
            ]);

        if ($response->status() === 403 || $response->status() === 401) {
            throw new \RuntimeException(
                '商工平臺拒絕連線（HTTP '.$response->status().'）。若正式機 IP 被擋，請改從可連線環境查詢。'
            );
        }

        if (! $response->successful()) {
            throw new \RuntimeException('商工平臺回應異常（HTTP '.$response->status().'）。');
        }

        $body = trim((string) $response->body());
        if ($body === '' || $body === 'null') {
            return [];
        }

        $json = $response->json();
        if ($json === null) {
            return [];
        }
        if (! is_array($json)) {
            throw new \RuntimeException('商工平臺回傳格式無法解析。');
        }
        if ($json === []) {
            return [];
        }
        if (isset($json[0]) || array_is_list($json)) {
            return array_values($json);
        }

        return [$json];
    }

    protected function throttle(): void
    {
        $us = (int) config('gcis.delay_microseconds', 300000);
        if ($us > 0) {
            usleep($us);
        }
    }

    /**
     * @param  list<string>  $header
     * @return array{name: ?int, tax_id: ?int, has_header: bool}
     */
    protected function detectExcelColumns(array $header): array
    {
        $name = null;
        $taxId = null;

        foreach ($header as $index => $label) {
            $key = preg_replace('/\s+/u', '', mb_strtolower(trim((string) $label)));
            if ($key === '') {
                continue;
            }
            if ($taxId === null && (
                str_contains($key, '統一編號')
                || str_contains($key, '統編')
                || $key === 'taxid'
                || $key === 'vat'
                || $key === 'business_accounting_no'
            )) {
                $taxId = (int) $index;
                continue;
            }
            if ($name === null && (
                str_contains($key, '公司名稱')
                || str_contains($key, '商業名稱')
                || str_contains($key, '商號')
                || $key === '名稱'
                || $key === 'company'
                || $key === 'companyname'
            )) {
                $name = (int) $index;
            }
        }

        if ($taxId !== null) {
            return ['name' => $name, 'tax_id' => $taxId, 'has_header' => true];
        }

        // 無表頭：假設 A=公司名稱、B=統一編號，且第一列就是資料
        if (count($header) >= 2) {
            $maybeTax = $this->normalizeTaxId((string) ($header[1] ?? ''));
            if (preg_match('/^\d{8}$/', $maybeTax)) {
                return ['name' => 0, 'tax_id' => 1, 'has_header' => false];
            }
        }

        return ['name' => null, 'tax_id' => null, 'has_header' => true];
    }

    protected function namesLikelyMatch(string $a, string $b): bool
    {
        $na = preg_replace('/\s+/u', '', $a) ?? '';
        $nb = preg_replace('/\s+/u', '', $b) ?? '';

        return $na !== '' && $nb !== '' && ($na === $nb || str_contains($nb, $na) || str_contains($na, $nb));
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array<string, mixed>
     */
    protected function normalizeCompanyRow(array $row): array
    {
        return [
            'tax_id' => (string) ($row['Business_Accounting_NO'] ?? ''),
            'name' => (string) ($row['Company_Name'] ?? ''),
            'status' => (string) ($row['Company_Status_Desc'] ?? ''),
            'case_status' => (string) ($row['Case_Status_Desc'] ?? ''),
            'capital' => $this->formatAmount($row['Capital_Stock_Amount'] ?? null),
            'paid_in_capital' => $this->formatAmount($row['Paid_In_Capital_Amount'] ?? null),
            'responsible_name' => (string) ($row['Responsible_Name'] ?? ''),
            'location' => (string) ($row['Company_Location'] ?? ''),
            'register_org' => (string) ($row['Register_Organization_Desc'] ?? ''),
            'setup_date' => $this->formatRocDate($row['Company_Setup_Date'] ?? null),
            'change_date' => $this->formatRocDate($row['Change_Of_Approval_Data'] ?? null),
            'raw' => $row,
        ];
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array<string, mixed>
     */
    protected function normalizeBusinessRow(array $row): array
    {
        $items = $row['Business_Item_Old'] ?? [];
        if (! is_array($items)) {
            $items = [];
        }

        $mappedItems = [];
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }
            $mappedItems[] = [
                'Business_Item' => (string) ($item['Business_Item'] ?? ''),
                'Business_Item_Desc' => (string) ($item['Business_Item_Desc'] ?? ''),
            ];
        }

        return [
            'tax_id' => (string) ($row['President_No'] ?? ''),
            'name' => (string) ($row['Business_Name'] ?? ''),
            'status' => (string) ($row['Business_Current_Status_Desc'] ?? $row['Business_Current_Status'] ?? ''),
            'org_type' => (string) ($row['Business_Organization_Type_Desc'] ?? ''),
            'agency' => (string) ($row['Agency_Desc'] ?? ''),
            'address' => (string) ($row['Business_Address'] ?? ''),
            'setup_date' => $this->formatRocDate($row['Business_Setup_Approve_Date'] ?? null),
            'items' => $mappedItems,
            'raw' => $row,
        ];
    }

    protected function formatAmount(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        if (! is_numeric($value)) {
            return (string) $value;
        }

        return number_format((float) $value);
    }

    protected function formatRocDate(mixed $value): string
    {
        $text = preg_replace('/\D+/', '', (string) ($value ?? '')) ?? '';
        if ($text === '') {
            return '';
        }
        if (strlen($text) === 7) {
            $rocYear = (int) substr($text, 0, 3);
            $month = substr($text, 3, 2);
            $day = substr($text, 5, 2);

            return sprintf('%04d-%s-%s（民%d）', $rocYear + 1911, $month, $day, $rocYear);
        }
        if (strlen($text) === 8) {
            return substr($text, 0, 4).'-'.substr($text, 4, 2).'-'.substr($text, 6, 2);
        }

        return (string) $value;
    }

    protected function friendlyError(Throwable $e): string
    {
        Log::warning('gcis_lookup_failed', ['message' => $e->getMessage()]);

        if ($e instanceof ConnectionException) {
            return '無法連線至商工平臺，請稍後再試。';
        }

        return '查詢失敗：'.$e->getMessage();
    }
}
