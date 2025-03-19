<?php

namespace App\Services;

use App\Models\Product;
use App\Services\PricingStrategy\PricingStrategyInterface;

class BasketService
{

    public function __construct(
        private PricingStrategyInterface $pricingStrategy
    ) {}

    public function addToBasket(string $code, int $quantity = 1): array
    {
        $product = Product::where('code', $code)->firstOrFail();
        if (!$product) {
            throw new \Exception("Product not found!");
        }

        return [
            'code' => $product->code,
            'quantity' => $quantity,
        ];
    }

    public function getTotal(array $basketItems): float
    {
        return $this->pricingStrategy->calculateTotal($basketItems);
    }
}
