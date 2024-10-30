<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckQuantity implements ValidationRule
{
    public $orderables;

    public function __construct($orderables) {
        $this->orderables = $orderables;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $orderables = $this->orderables;
        
        $orderableIds = array_column($orderables, 'orderable_id');

        $products = Product::whereIn('id', $orderableIds)->get();

        $productsById = $products->keyBy('id');

        foreach ($orderables as $orderable) {
            $orderableId = $orderable['orderable_id'];
            $quantityRequested = $orderable['quantity'];

            if (isset($productsById[$orderableId])) {
                $product = $productsById[$orderableId];

                if ($quantityRequested > $product->quantity) {
                    $fail('The quantity of product ' . $product->type . ' must be less than or equal to ' . $product->quantity);
                }
            } else {
                $fail('Product with ID ' . $orderableId . ' not found.');
            }
        }
    }
}
