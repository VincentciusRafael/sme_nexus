<?php

namespace App\Http\Controllers\BusinessAutopsy\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessAutopsy\StoreRuleRequest;
use App\Http\Requests\BusinessAutopsy\UpdateRuleRequest;
use App\Models\BusinessAutopsy\Rule;
use App\Services\BusinessAutopsy\DiagnosisService;
use App\Services\BusinessAutopsy\RuleService;
use App\Services\BusinessAutopsy\SymptomService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RuleController extends Controller
{
    public function __construct(
        private readonly RuleService $rules,
        private readonly DiagnosisService $diagnoses,
        private readonly SymptomService $symptoms,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'id_diagnosis', 'is_active']);

        if (($filters['is_active'] ?? '') === '') {
            $filters['is_active'] = null;
        }

        return view('business-autopsy.admin.rules.index', [
            'rules' => $this->rules->paginate($filters),
            'filters' => $filters,
            'diagnoses' => $this->diagnoses->allActive(),
        ]);
    }

    public function create(): View
    {
        return view('business-autopsy.admin.rules.form', [
            'rule' => new Rule(['severity' => 'medium', 'priority' => 100, 'is_active' => false]),
            'version' => null,
            'diagnoses' => $this->diagnoses->allActive(),
            'symptoms' => $this->symptoms->all(),
        ]);
    }

    public function store(StoreRuleRequest $request): RedirectResponse
    {
        [$data, $groups] = $this->prepareData($request->validated());

        $rule = $this->rules->create($data, $groups);

        return redirect()
            ->route('admin.business-autopsy.rules.show', $rule)
            ->with('success', 'Rule berhasil dibuat sebagai draf. Tinjau lalu publikasikan.');
    }

    public function show(Rule $rule): View
    {
        $rule = $this->rules->find($rule->getKey());

        return view('business-autopsy.admin.rules.show', [
            'rule' => $rule,
            'version' => $this->rules->latestVersion($rule),
        ]);
    }

    public function edit(Rule $rule): View
    {
        $rule = $this->rules->find($rule->getKey());

        return view('business-autopsy.admin.rules.form', [
            'rule' => $rule,
            'version' => $this->rules->latestVersion($rule),
            'diagnoses' => $this->diagnoses->allActive(),
            'symptoms' => $this->symptoms->all(),
        ]);
    }

    public function update(UpdateRuleRequest $request, Rule $rule): RedirectResponse
    {
        [$data, $groups] = $this->prepareData($request->validated());
        unset($data['is_active']);

        $rule = $this->rules->update($rule, $data, $groups);

        return redirect()
            ->route('admin.business-autopsy.rules.show', $rule)
            ->with('success', 'Rule berhasil diperbarui. Perubahan tersimpan sebagai draf baru.');
    }

    public function publish(Rule $rule): RedirectResponse
    {
        try {
            $this->rules->publish($rule);

            return back()->with('success', 'Rule berhasil dipublikasikan.');
        } catch (DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function deactivate(Rule $rule): RedirectResponse
    {
        $this->rules->deactivate($rule);

        return back()->with('success', 'Rule berhasil dinonaktifkan.');
    }

    public function activate(Rule $rule): RedirectResponse
    {
        try {
            $this->rules->activate($rule);

            return back()->with('success', 'Rule berhasil diaktifkan.');
        } catch (DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array{0: array<string, mixed>, 1: array<int, array<string, mixed>>}
     */
    private function prepareData(array $data): array
    {
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $groups = $data['groups'] ?? [];
        unset($data['groups']);

        return [$data, $groups];
    }
}
