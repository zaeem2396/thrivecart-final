<?php

use App\Services\PricingStrategy\DefaultPricingStrategy;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->pricingStrategy = new DefaultPricingStrategy();

    Product::factory()->create(['code' => 'B01', 'name' => 'Blue Widget', 'price' => 7.95]);
    Product::factory()->create(['code' => 'G01', 'name' => 'Green Widget', 'price' => 24.95]);
    Product::factory()->create(['code' => 'R01', 'name' => 'Red Widget', 'price' => 32.95]);
});

test('calculates total without discounts', function () {
    $basketItems = [
        ['code' => 'B01', 'quantity' => 1],
        ['code' => 'G01', 'quantity' => 1],
    ];

    $total = $this->pricingStrategy->calculateTotal($basketItems);
    expect($total)->toBe(37.85);
});

test('applies red widget discount correctly', function () {
    $basketItems = [
        ['code' => 'R01', 'quantity' => 2]
    ];

    $total = $this->pricingStrategy->calculateTotal($basketItems);
    expect($total)->toBe(54.37);
});
