<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Enums\ReportType;
use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FinancialReportController extends Controller
{
    public function index(): View
    {
        return view('admin.reports.index', [
            'reports' => FinancialReport::with('uploader')->orderByDesc('year')->orderByDesc('published_at')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.reports.form', [
            'report' => new FinancialReport([
                'type' => ReportType::Publikasi,
                'year' => (int) now()->format('Y'),
                'status' => PublishStatus::Published,
                'published_at' => now(),
            ]),
            'types' => ReportType::cases(),
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['uploaded_by'] = $request->user()?->id;

        FinancialReport::create($data);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan keuangan PDF berhasil diunggah.');
    }

    public function edit(FinancialReport $report): View
    {
        return view('admin.reports.form', [
            'report' => $report,
            'types' => ReportType::cases(),
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function update(Request $request, FinancialReport $report): RedirectResponse
    {
        $data = $this->validatedData($request, $report);
        $report->update($data);

        return redirect()->route('admin.reports.index')->with('success', 'Data laporan keuangan berhasil diperbarui.');
    }

    public function destroy(FinancialReport $report): RedirectResponse
    {
        $report->delete();

        return redirect()->route('admin.reports.index')->with('success', 'Laporan keuangan berhasil dihapus.');
    }

    private function validatedData(Request $request, ?FinancialReport $report = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'type' => ['required', Rule::enum(ReportType::class)],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'period' => ['required', 'string', 'max:50'],
            'published_at' => ['nullable', 'date'],
            'status' => ['required', Rule::enum(PublishStatus::class)],
            'file' => [$report ? 'nullable' : 'required', 'file', 'mimes:pdf', 'max:20480'],
        ], [
            'file.required' => 'Berkas PDF wajib diunggah.',
            'file.mimes' => 'Berkas laporan harus berformat PDF.',
            'file.max' => 'Ukuran berkas PDF maksimal 20 MB.',
        ]);

        $data = [
            'title' => $validated['title'],
            'type' => $validated['type'],
            'year' => (int) $validated['year'],
            'period' => $validated['period'],
            'published_at' => $validated['published_at'] ?? now(),
            'status' => $validated['status'],
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('reports', 'public');
            $data['file_size'] = $file->getSize() ?: 0;
        }

        return $data;
    }
}
