<?php

namespace App\Http\Requests\BusinessAutopsy;

use App\Domain\BusinessAutopsy\Enums\RuleOperator;
use App\Domain\BusinessAutopsy\Enums\Severity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSymptomRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $symptom = $this->route('symptom');

        return [
            'code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('autopsy_symptoms', 'code')->ignore($symptom?->getKey()),
            ],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'metric_key' => ['required', 'string', 'max:100'],
            'operator' => ['required', Rule::in(array_column(RuleOperator::cases(), 'value'))],
            'threshold' => ['required', 'numeric'],
            'severity' => ['required', Rule::in(array_column(Severity::cases(), 'value'))],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
