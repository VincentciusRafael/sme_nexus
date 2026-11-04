<?php

namespace App\Repositories\BusinessAutopsy;

use App\Models\BusinessCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BusinessCategoryRepository
{
    /**
     * @param  array<string, mixed>  $filters
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return BusinessCategory::query()
            ->withCount('smeProfiles')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('category_name', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->orderBy('category_name')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function all()
    {
        return BusinessCategory::query()->orderBy('category_name')->get();
    }

    public function find(int $id): BusinessCategory
    {
        return BusinessCategory::query()->findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): BusinessCategory
    {
        return BusinessCategory::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(BusinessCategory $category, array $data): BusinessCategory
    {
        $category->update($data);

        return $category->refresh();
    }

    public function delete(BusinessCategory $category): void
    {
        $category->delete();
    }

    public function hasProfiles(BusinessCategory $category): bool
    {
        return $category->smeProfiles()->exists();
    }
}
