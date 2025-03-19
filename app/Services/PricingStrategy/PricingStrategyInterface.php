<?php

namespace App\Services\PricingStrategy;

interface PricingStrategyInterface
{
    public function calculateTotal(array $items): float;
}
