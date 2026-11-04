<?php

namespace App\Services\BusinessAutopsy;

use App\Models\BusinessAutopsy\Recommendation;
use App\Repositories\BusinessAutopsy\RecommendationRepository;

class RecommendationService
{
    public function __construct(
        private readonly RecommendationRepository $recommendations,
        private readonly AuditLogger $auditLogger,
    ) {}

    /**
     * @param  array<string, mixed>  $filters
     */
    public function paginate(array $filters = [])
    {
        return $this->recommendations->paginate($filters);
    }

    public function find(int $id): Recommendation
    {
        return $this->recommendations->find($id);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Recommendation
    {
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        $data['action_steps'] = array_values(array_filter($data['action_steps'] ?? []));

        $recommendation = $this->recommendations->create($data);

        $this->auditLogger->log('admin.recommendation.created', 'autopsy_recommendation', $recommendation->getKey(), [], $data);

        return $recommendation;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Recommendation $recommendation, array $data): Recommendation
    {
        $oldValues = $recommendation->only([
            'id_diagnosis',
            'code',
            'title',
            'description',
            'action_steps',
            'priority',
            'is_active',
        ]);

        $data['updated_by'] = auth()->id();
        $data['action_steps'] = array_values(array_filter($data['action_steps'] ?? []));
        $recommendation = $this->recommendations->update($recommendation, $data);

        $this->auditLogger->log('admin.recommendation.updated', 'autopsy_recommendation', $recommendation->getKey(), $oldValues, $data);

        return $recommendation;
    }

    public function deactivate(Recommendation $recommendation): Recommendation
    {
        $recommendation = $this->recommendations->deactivate($recommendation);

        $this->auditLogger->log('admin.recommendation.deactivated', 'autopsy_recommendation', $recommendation->getKey(), ['is_active' => true], ['is_active' => false]);

        return $recommendation;
    }

    public function activate(Recommendation $recommendation): Recommendation
    {
        $recommendation->update(['is_active' => true, 'updated_by' => auth()->id()]);

        $this->auditLogger->log('admin.recommendation.activated', 'autopsy_recommendation', $recommendation->getKey(), ['is_active' => false], ['is_active' => true]);

        return $recommendation->refresh();
    }
}
