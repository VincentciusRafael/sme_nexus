<?php

namespace App\Http\Controllers\BusinessAutopsy\Admin;

use App\Domain\BusinessAutopsy\Enums\Severity;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessAutopsy\StoreDiagnosisRequest;
use App\Http\Requests\BusinessAutopsy\UpdateDiagnosisRequest;
use App\Models\BusinessAutopsy\Diagnosis;
use App\Services\BusinessAutopsy\DiagnosisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiagnosisController extends Controller
{
    public function __construct(private readonly DiagnosisService $diagnoses) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'is_active']);

        if (($filters['is_active'] ?? '') === '') {
            $filters['is_active'] = null;
        }

        return view('business-autopsy.admin.diagnoses.index', [
            'diagnoses' => $this->diagnoses->paginate($filters),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('business-autopsy.admin.diagnoses.form', [
            'diagnosis' => new Diagnosis([
                'severity' => Severity::Medium,
                'priority' => 100,
                'is_active' => true,
            ]),
            'severities' => Severity::cases(),
        ]);
    }

    public function store(StoreDiagnosisRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $this->diagnoses->create($data);

        return redirect()
            ->route('admin.business-autopsy.diagnoses.index')
            ->with('success', 'Master diagnosis berhasil ditambahkan.');
    }

    public function edit(Diagnosis $diagnosis): View
    {
        return view('business-autopsy.admin.diagnoses.form', [
            'diagnosis' => $diagnosis,
            'severities' => Severity::cases(),
        ]);
    }

    public function update(UpdateDiagnosisRequest $request, Diagnosis $diagnosis): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $this->diagnoses->update($diagnosis, $data);

        return redirect()
            ->route('admin.business-autopsy.diagnoses.index')
            ->with('success', 'Master diagnosis berhasil diperbarui.');
    }

    public function deactivate(Diagnosis $diagnosis): RedirectResponse
    {
        $this->diagnoses->deactivate($diagnosis);

        return back()->with('success', 'Master diagnosis berhasil dinonaktifkan.');
    }

    public function activate(Diagnosis $diagnosis): RedirectResponse
    {
        $this->diagnoses->activate($diagnosis);

        return back()->with('success', 'Master diagnosis berhasil diaktifkan.');
    }
}
