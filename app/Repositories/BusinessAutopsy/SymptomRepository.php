<?php

namespace App\Repositories\BusinessAutopsy;

use App\Models\BusinessAutopsy\Symptom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SymptomRepository
{
    /**
     * @param  array<string, mixed>  $filters
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Symptom::query()
            ->withCount('conditions')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('metric_key', 'like', "%{$search}%");
                });
            })
            ->when(array_key_exists('is_active', $filters) && $filters['is_active'] !== null, function ($query) use ($filters) {
                $query->where('is_active', (bool) $filters['is_active']);
            })
            ->when($filters['id_symptom'] ?? null, fn ($query, $id) => $query->whereKey($id))
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function allActive()
    {
        return Symptom::query()->active()->orderBy('name')->get();
    }

    public function all()
    {
        return Symptom::query()
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->get();
    }

    public function find(int $id): Symptom
    {
        return Symptom::query()->findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Symptom
    {
        return Symptom::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Symptom $symptom, array $data): Symptom
    {
        $symptom->update($data);

        return $symptom->refresh();
    }

    public function deactivate(Symptom $symptom): Symptom
    {
        $symptom->update(['is_active' => false]);

        return $symptom->refresh();
    }

    public function isUsed(Symptom $symptom): bool
    {
        return $symptom->conditions()->exists();
    }
}
