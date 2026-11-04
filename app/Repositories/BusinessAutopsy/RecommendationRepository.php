<?php

namespace App\Repositories\BusinessAutopsy;

use App\Models\BusinessAutopsy\Recommendation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RecommendationRepository
{
    /**
     * @param  array<string, mixed>  $filters
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Recommendation::query()
            ->with('diagnosis')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                });
            })
            ->when($filters['id_diagnosis'] ?? null, fn ($query, $diagnosis) => $query->where('id_diagnosis', $diagnosis))
            ->when(array_key_exists('is_active', $filters) && $filters['is_active'] !== null, function ($query) use ($filters) {
                $query->where('is_active', (bool) $filters['is_active']);
            })
            ->orderBy('priority')
            ->orderBy('title')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(int $id): Recommendation
    {
        return Recommendation::query()->with('diagnosis')->findOrFail($id);
    }

    public function activeForDiagnosis(int $diagnosisId)
    {
        return Recommendation::query()
            ->where('id_diagnosis', $diagnosisId)
            ->where('is_active', true)
            ->orderBy('priority')
            ->orderBy('title')
            ->get();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Recommendation
    {
        return Recommendation::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Recommendation $recommendation, array $data): Recommendation
    {
        $recommendation->update($data);

        return $recommendation->refresh();
    }

    public function deactivate(Recommendation $recommendation): Recommendation
    {
        $recommendation->update(['is_active' => false]);

        return $recommendation->refresh();
    }
}
