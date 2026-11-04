<?php

namespace App\Services\BusinessAutopsy;

use App\Models\BusinessAutopsy\Symptom;
use App\Repositories\BusinessAutopsy\SymptomRepository;
use Illuminate\Support\Collection;

class SymptomDetectionService
{
    public function __construct(private readonly SymptomRepository $symptoms) {}

    /**
     * Deteksi gejala aktif dari metrik bisnis.
     *
     * @param  array<string, float|int|string|null>  $metrics
     * @return Collection<int, Symptom>
     */
    public function detect(array $metrics): Collection
    {
        return $this->symptoms->allActive()
            ->filter(function (Symptom $symptom) use ($metrics): bool {
                $value = $metrics[$symptom->metric_key] ?? null;

                if (! is_numeric($value) || ! is_finite((float) $value)) {
                    return false;
                }

                return $symptom->operator->matches((float) $value, (float) $symptom->threshold);
            })
            ->values();
    }
}
