<?php

namespace App\Services\BusinessAutopsy\DTOs;

use App\Models\BusinessAutopsy\Diagnosis;
use App\Models\BusinessAutopsy\Recommendation;
use App\Models\BusinessAutopsy\Rule;
use App\Models\BusinessAutopsy\RuleVersion;
use App\Models\BusinessAutopsy\Symptom;
use Illuminate\Support\Collection;

final readonly class DiagnosisEvaluationResult
{
    /**
     * @param  array<string, float|int|string|null>  $metrics
     * @param  Collection<int, Symptom>  $detectedSymptoms
     * @param  array<int, array<string, mixed>>  $matchedCandidates
     * @param  array<string, mixed>|null  $primaryCandidate
     * @param  Collection<int, Recommendation>  $recommendations
     */
    public function __construct(
        public array $metrics,
        public Collection $detectedSymptoms,
        public array $matchedCandidates,
        public ?array $primaryCandidate,
        public Collection $recommendations,
    ) {}

    public function primaryRule(): ?Rule
    {
        return $this->primaryCandidate['rule'] ?? null;
    }

    public function primaryVersion(): ?RuleVersion
    {
        return $this->primaryCandidate['version'] ?? null;
    }

    public function primaryDiagnosis(): ?Diagnosis
    {
        return $this->primaryCandidate['diagnosis'] ?? null;
    }

    public function hasMatch(): bool
    {
        return $this->primaryCandidate !== null;
    }
}
