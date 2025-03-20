<?php

namespace App\Services\PricingStrategy;

use App\Models\AppSetting;
use App\Models\Product;
use App\Services\PricingStrategy\PricingStrategyInterface;

class DefaultPricingStrategy implements PricingStrategyInterface
{
    public function calculateTotal(array $items): float
    {
        $total = 0;
        $redWidgetCount = 0;

        foreach ($items as $item) {
            $product = Product::where('code', $item['code'])->firstOrFail();

            if ($product->code === 'R01') {
                for ($i = 1; $i <= $item['quantity']; $i++) {
                    $redWidgetCount++;
                    if ($redWidgetCount % 2 == 0) {
                        $total += $product->price / 2;
                    } else {
                        $total += $product->price;
                    }
                }
            } else {
                $total += $product->price * $item['quantity'];
            }
        }

        $chargeBelow50 = (float) AppSetting::getValue('delivery_charge_below_50', '4.95');
        $chargeBelow90 = (float) AppSetting::getValue('delivery_charge_below_90', '2.95');
        $freeThreshold = (float) AppSetting::getValue('delivery_charge_free_threshold', '90');

        if ($total < 50) return $total + $chargeBelow50;
        if ($total < $freeThreshold) return $total + $chargeBelow90;
        return $total;
    }
}
