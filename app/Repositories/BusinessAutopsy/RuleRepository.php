<?php

namespace App\Repositories\BusinessAutopsy;

use App\Domain\BusinessAutopsy\Enums\RuleVersionStatus;
use App\Models\BusinessAutopsy\Rule;
use App\Models\BusinessAutopsy\RuleGroup;
use App\Models\BusinessAutopsy\RuleVersion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RuleRepository
{
    /**
     * @param  array<string, mixed>  $filters
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Rule::query()
            ->with(['diagnosis', 'activeVersion'])
            ->withCount('versions')
            ->withExists([
                'versions as has_published_version' => fn ($query) => $query->where('status', RuleVersionStatus::Published->value),
            ])
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->when($filters['id_diagnosis'] ?? null, fn ($query, $diagnosis) => $query->where('id_diagnosis', $diagnosis))
            ->when(array_key_exists('is_active', $filters) && $filters['is_active'] !== null, function ($query) use ($filters) {
                $query->where('is_active', (bool) $filters['is_active']);
            })
            ->orderByDesc('is_active')
            ->orderBy('priority')
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(int $id): Rule
    {
        return Rule::query()
            ->with([
                'diagnosis',
                'activeVersion.groups.conditions.symptom',
                'versions.groups.conditions.symptom',
                'createdBy',
                'updatedBy',
            ])
            ->findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Rule
    {
        return Rule::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Rule $rule, array $data): Rule
    {
        $rule->update($data);

        return $rule->refresh();
    }

    public function latestVersion(Rule $rule): ?RuleVersion
    {
        return $rule->versions()
            ->with('groups.conditions.symptom')
            ->orderByDesc('version')
            ->first();
    }

    /**
     * Versi aktif yang dipublikasikan untuk evaluasi diagnosis baru.
     */
    public function activePublishedForEvaluation()
    {
        return RuleVersion::query()
            ->where('status', RuleVersionStatus::Published->value)
            ->where('is_active', true)
            ->whereHas('rule', fn ($query) => $query->where('is_active', true))
            ->whereHas('rule.diagnosis', fn ($query) => $query->where('is_active', true))
            ->with(['rule.diagnosis', 'groups.conditions.symptom'])
            ->get();
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, array<string, mixed>>  $groups
     */
    public function createVersion(Rule $rule, array $data, array $groups): RuleVersion
    {
        return DB::transaction(function () use ($rule, $data, $groups) {
            $version = $rule->versions()->create($data);
            $this->syncGroups($version, $groups);

            return $version->refresh()->load('groups.conditions.symptom');
        });
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, array<string, mixed>>  $groups
     */
    public function updateDraftVersion(RuleVersion $version, array $data, array $groups): RuleVersion
    {
        return DB::transaction(function () use ($version, $data, $groups) {
            $version->update($data);
            $this->syncGroups($version, $groups);

            return $version->refresh()->load('groups.conditions.symptom');
        });
    }

    public function publishVersion(RuleVersion $version): RuleVersion
    {
        return DB::transaction(function () use ($version) {
            RuleVersion::query()
                ->where('id_rule', $version->id_rule)
                ->update(['is_active' => false]);

            $version->update([
                'status' => RuleVersionStatus::Published->value,
                'is_active' => true,
                'published_at' => now(),
            ]);

            return $version->refresh()->load('groups.conditions.symptom');
        });
    }

    public function deactivate(Rule $rule): Rule
    {
        return DB::transaction(function () use ($rule) {
            RuleVersion::query()
                ->where('id_rule', $rule->getKey())
                ->update(['is_active' => false]);
            $rule->update(['is_active' => false]);

            return $rule->refresh();
        });
    }

    public function activate(Rule $rule): Rule
    {
        return DB::transaction(function () use ($rule) {
            $latestPublishedVersion = $rule->versions()
                ->where('status', RuleVersionStatus::Published->value)
                ->orderByDesc('version')
                ->first();

            if ($latestPublishedVersion) {
                RuleVersion::query()
                    ->where('id_rule', $rule->getKey())
                    ->update(['is_active' => false]);

                $latestPublishedVersion->update(['is_active' => true]);
            }

            $rule->update(['is_active' => true]);

            return $rule->refresh();
        });
    }

    public function findVersion(Rule $rule, int $versionId): RuleVersion
    {
        return $rule->versions()->with('groups.conditions.symptom')->findOrFail($versionId);
    }

    /**
     * @param  array<int, array<string, mixed>>  $groups
     */
    private function syncGroups(RuleVersion $version, array $groups): void
    {
        RuleGroup::query()->where('id_rule_version', $version->getKey())->delete();

        foreach (array_values($groups) as $index => $groupData) {
            $group = RuleGroup::query()->create([
                'id_rule_version' => $version->getKey(),
                'group_order' => $index + 1,
                'label' => $groupData['label'] ?? null,
            ]);

            foreach ($groupData['conditions'] ?? [] as $conditionData) {
                $group->conditions()->create([
                    'id_symptom' => $conditionData['id_symptom'],
                    'is_negated' => (bool) ($conditionData['is_negated'] ?? false),
                ]);
            }
        }
    }
}
