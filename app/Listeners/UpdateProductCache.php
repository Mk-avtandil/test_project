<?php

namespace App\Listeners;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class UpdateProductCache
{
    public function handle(Product $product): void
    {
        Cache::forget('all_products');
        Cache::put('all_products', Product::all(), 60);
    }

}
