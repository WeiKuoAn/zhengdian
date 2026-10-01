<?php

namespace App\Http\Controllers;

use App\Models\CustData;
use App\Services\GcisBusinessRegistryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class CompanyTaxLookupController extends Controller
{
    public function index(Request $request, GcisBusinessRegistryService $gcis): View
    {
        $taxId = trim((string) $request->input('tax_id', ''));
        $result = null;
        $localCustomer = null;
        $batch = session('company_tax_lookup_batch');

        if ($taxId !== '') {
            $normalized = $gcis->normalizeTaxId($taxId);
            $result = $gcis->lookupByTaxId($normalized, false);

            if ($normalized !== '') {
                $localCustomer = CustData::query()
                    ->with('user_data')
                    ->where('registration_no', $normalized)
                    ->first();
            }

            $taxId = $normalized !== '' ? $normalized : $taxId;
        }

        return view('company_tax_lookup.index', [
            'taxId' => $taxId,
            'result' => $result,
            'localCustomer' => $localCustomer,
            'batch' => $batch,
        ]);
    }

    public function batch(Request $request, GcisBusinessRegistryService $gcis): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx', 'max:5120'],
        ], [
            'file.required' => '請上傳 Excel 檔案',
            'file.mimes' => '僅支援 .xlsx',
        ]);

        try {
            $batch = $gcis->lookupFromExcel($request->file('file')->getRealPath());
        } catch (Throwable $e) {
            return redirect()
                ->route('company.tax.lookup')
                ->with('error', '讀取 Excel 失敗：'.$e->getMessage());
        }

        return redirect()
            ->route('company.tax.lookup')
            ->with('success', sprintf(
                '批次查詢完成：共 %d 筆，查得 %d、查無 %d、錯誤 %d',
                $batch['summary']['total'],
                $batch['summary']['found'],
                $batch['summary']['missing'],
                $batch['summary']['errors']
            ))
            ->with('company_tax_lookup_batch', $batch);
    }

    public function downloadTemplate(): StreamedResponse
    {
        $filename = '統編查詢範本.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            // Excel UTF-8 BOM
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['公司名稱', '統一編號']);
            fputcsv($out, ['宏碁股份有限公司', '20828393']);
            fputcsv($out, ['範例商行', '15725713']);
            fputcsv($out, ['前導零範例', '04525306']);
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
