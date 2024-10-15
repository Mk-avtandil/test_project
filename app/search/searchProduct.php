<?php

namespace App\search;

use App\Models\Product;
use Illuminate\Http\Request;

class searchProduct
{
    public function get($request)
    {
        $query = Product::query()->with('comments');

        if ($request->has('type') && $request->type !== null) {
            $query->where('type', $request->type);
        }

        if ($request->has('price_from') && $request->price_from !== null) {
            $query->where('price', '>=',  $request->price_from);
        }

        if ($request->has('price_to') && $request->price_to !== null) {
            $query->where('price', '<=',  $request->price_to);
        }

        if ($request->has('color') && $request->color !== null) {
            $query->where('color',  $request->color);
        }

        if ($request->has('size') && $request->size !== null) {
            $query->where('size',  $request->size);
        }

        if ($request->has('is_in_stock') && $request->is_in_stock !== null) {
            $query->where('is_in_stock',  $request->is_in_stock);
        }

        return $query->paginate($request->per_page ?? 25);
    }

}
