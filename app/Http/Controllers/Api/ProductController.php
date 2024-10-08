<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use App\search\searchProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): ProductCollection
    {
        $products = new searchProduct();
        $result = $products->get($request);

        return new ProductCollection($result);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function getAllProducts(Request $request): ProductCollection
    {
        $products = Cache::remember('all_products', 60, function () {
            return Product::all();
        });

        return new ProductCollection($products);
    }


}
