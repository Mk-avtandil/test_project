<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use App\Search\SearchProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): ProductCollection
    {
        $products = new SearchProduct();
        $paramsForSearch = $this->filterParams($request);
        $result = $products->get($paramsForSearch);

        return new ProductCollection($result);
    }

    public function show($id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['data' => $product], 200);
    }

    public function getAllProducts(Request $request): ProductCollection
    {
        $products = Cache::rememberForever('all_products', function () {
            return Product::with(['comments', 'medias'])->get();
        });

        return new ProductCollection($products);
    }

    private function filterParams($request): array
    {
        return [
            'type' => $request->get('type'),
            'price_from' => $request->get('price_from'),
            'price_to' => $request->get('price_to'),
            'color' => $request->get('color'),
            'size' => $request->get('size'),
            'quantity' => $request->get('quantity'),
            'per_page' => $request->get('per_page'),
        ];
    }
}
