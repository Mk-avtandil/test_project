<?php

namespace App\Search;

use App\Models\Product;

class SearchProduct
{
    public function get($search)
    {
        $query = Product::query()->with(['comments', 'medias']);

        if (!empty($search['type'])) {
            $query->where('type', $search['type']);
        }

        if (!empty($search['price_from'])) {
            $query->where('price', '>=',  $search['price_from']);
        }

        if (!empty($search['price_to'])) {
            $query->where('price', '<=',  $search['price_to']);
        }

        if (!empty($search['color'])) {
            $query->where('color',  $search['color']);
        }

        if (!empty($search['size'])) {
            $query->where('size',  $search['size']);
        }

        if (!empty($search['quantity'])) {
            $query->where('quantity', '>=',  $search['quantity']);
        }

        return $query->paginate($search['per_page'] ?? 25);
    }

}
