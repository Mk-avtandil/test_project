<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckQuantity implements ValidationRule
{
    private $orderable;
    public function __construct(mixed $orderable) {
        $this->orderable = $orderable;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->orderable->quantity == 0) {
            $fail("The Product '{$this->orderable->type}' is out of stock");
        } elseif ($value > $this->orderable->quantity) {
            $fail("The {$attribute} must be less than or equal to {$this?->orderable?->quantity}");
        }
    }
}
