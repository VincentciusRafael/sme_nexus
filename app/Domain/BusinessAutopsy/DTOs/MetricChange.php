<?php

namespace App\Domain\BusinessAutopsy\DTOs;

final readonly class MetricChange
{
    public function __construct(
        public float $difference,
        public ?float $percentage,
    ) {}
}
