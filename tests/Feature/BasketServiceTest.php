<?php

use App\Services\BasketService;
use App\Services\PricingStrategy\DefaultPricingStrategy;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->basketService = new BasketService(new DefaultPricingStrategy());

    Product::factory()->create(['code' => 'B01', 'name' => 'Blue Widget', 'price' => 7.95]);
    Product::factory()->create(['code' => 'G01', 'name' => 'Green Widget', 'price' => 24.95]);
    Product::factory()->create(['code' => 'R01', 'name' => 'Red Widget', 'price' => 32.95]);
});

test('can add product to basket', function () {
    $item = $this->basketService->addToBasket('B01');

    expect($item)->toBeArray();
    expect($item['code'])->toBe('B01');
    expect($item['quantity'])->toBe(1);
});

test('throws exception when adding non-existing product', function () {
    $this->expectException(ModelNotFoundException::class);
    $this->basketService->addToBasket('INVALID_CODE');
});
