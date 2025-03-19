<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\BasketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BasketController extends Controller
{
    public function __construct(
        private BasketService $basketService,
        private Product $product
    ) {}

    public function index(): View
    {
        $products = $this->product->all();
        return view('basket', compact('products'));
    }

    public function calculateTotal(Request $request): JsonResponse
    {
        try {
            $basketItems = $request->input('basket', []);
            $total = $this->basketService->getTotal($basketItems);

            return response()->json(['success' => true, 'total' => number_format($total, 2)]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
