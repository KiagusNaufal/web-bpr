<?php

namespace App\Http\Controllers;

use App\Enums\PublishStatus;
use App\Enums\ReportType;
use App\Models\FinancialReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FinancialReportController extends Controller
{
    public function index(Request $request): View
    {
        $selectedYear = $request->integer('tahun') ?: null;
        $selectedType = ReportType::tryFrom((string) $request->query('jenis'));

        $years = FinancialReport::published()
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $reports = FinancialReport::published()
            ->when($selectedYear, fn ($q) => $q->where('year', $selectedYear))
            ->when($selectedType, fn ($q) => $q->where('type', $selectedType->value))
            ->orderByDesc('year')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get();

        return view('pages.reports.index', [
            'reportsByYear' => $reports->groupBy('year'),
            'totalReports' => $reports->count(),
            'years' => $years,
            'reportTypes' => ReportType::cases(),
            'selectedYear' => $selectedYear,
            'selectedType' => $selectedType,
        ]);
    }

    public function preview(FinancialReport $report): BinaryFileResponse
    {
        $path = $this->resolveFilePath($report);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.Str::slug($report->title.'-'.$report->year).'.pdf"',
        ]);
    }

    public function download(FinancialReport $report): BinaryFileResponse
    {
        $path = $this->resolveFilePath($report);
        $filename = Str::slug($report->title.'-'.$report->year.'-'.$report->period).'.pdf';

        return response()->download($path, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    private function resolveFilePath(FinancialReport $report): string
    {
        abort_unless($report->status === PublishStatus::Published, 404);

        $raw = ltrim((string) $report->file_path, '/');

        if (Storage::disk('public')->exists($raw)) {
            return Storage::disk('public')->path($raw);
        }

        if (Storage::disk('local')->exists($raw)) {
            return Storage::disk('local')->path($raw);
        }

        $publicFile = public_path($raw);
        if (is_file($publicFile)) {
            return $publicFile;
        }

        abort(404, 'Berkas PDF laporan tidak ditemukan.');
    }
}
