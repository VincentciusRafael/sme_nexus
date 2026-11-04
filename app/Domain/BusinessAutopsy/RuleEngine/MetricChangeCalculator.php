<?php

namespace App\Domain\BusinessAutopsy\RuleEngine;

use App\Domain\BusinessAutopsy\DTOs\MetricChange;

final class MetricChangeCalculator
{
    public function calculate(float $currentValue, float $comparisonValue): MetricChange
    {
        $difference = $currentValue - $comparisonValue;
        $percentage = $comparisonValue === 0.0
            ? null
            : ($difference / $comparisonValue) * 100;

        return new MetricChange($difference, $percentage);
    }
}
