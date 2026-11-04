<?php

namespace App\Repositories\BusinessAutopsy;

use App\Models\BusinessAutopsy\Diagnosis;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DiagnosisRepository
{
    /**
     * @param  array<string, mixed>  $filters
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Diagnosis::query()
            ->withCount(['rules', 'recommendations'])
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->when(array_key_exists('is_active', $filters) && $filters['is_active'] !== null, function ($query) use ($filters) {
                $query->where('is_active', (bool) $filters['is_active']);
            })
            ->orderBy('priority')
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function allActive()
    {
        return Diagnosis::query()->active()->orderBy('priority')->orderBy('name')->get();
    }

    public function find(int $id): Diagnosis
    {
        return Diagnosis::query()->findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Diagnosis
    {
        return Diagnosis::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Diagnosis $diagnosis, array $data): Diagnosis
    {
        $diagnosis->update($data);

        return $diagnosis->refresh();
    }

    public function deactivate(Diagnosis $diagnosis): Diagnosis
    {
        $diagnosis->update(['is_active' => false]);

        return $diagnosis->refresh();
    }

    public function isUsed(Diagnosis $diagnosis): bool
    {
        return $diagnosis->rules()->exists() || $diagnosis->recommendations()->exists();
    }
}
