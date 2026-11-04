<?php

namespace App\Services\BusinessAutopsy;

use App\Models\BusinessAutopsy\Diagnosis;
use App\Models\BusinessAutopsy\Recommendation;
use App\Models\BusinessAutopsy\Rule;
use App\Models\BusinessAutopsy\Symptom;
use App\Models\SmeProfile;
use App\Models\User;

class AdminDashboardService
{
    public function __construct(private readonly AuditLogService $auditLogs) {}

    /**
     * @return array<string, int|mixed>
     */
    public function summary(): array
    {
        return [
            'users' => User::query()->count(),
            'owners' => User::query()->where('role', 'sme_owner')->count(),
            'profiles' => SmeProfile::query()->count(),
            'symptoms' => Symptom::query()->active()->count(),
            'diagnoses' => Diagnosis::query()->active()->count(),
            'rules' => Rule::query()->active()->count(),
            'recommendations' => Recommendation::query()->active()->count(),
            'recent_logs' => $this->auditLogs->recent(6),
        ];
    }
}
