<?php

namespace App\Domain\BusinessAutopsy\DTOs;

use App\Domain\BusinessAutopsy\Enums\RuleOperator;

final readonly class RuleCondition
{
    public function __construct(
        public string $metricCode,
        public RuleOperator $operator,
        public float $threshold,
        public int $groupNumber = 1,
    ) {}
}
