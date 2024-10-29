<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Relations\Relation;

class CheckQuantity implements ValidationRule
{
    public string $orderable_type;
    public int $orderable_id;
    public function __construct(string $orderable_type, string $orderable_id) {
        $this->orderable_type = $orderable_type;
        $this->orderable_id = $orderable_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $orderable = (Relation::getMorphedModel($this->orderable_type))::findOrFail($this->orderable_id);
        if ($orderable?->quantity === 0) {
            $fail("The Product '{$orderable?->type}' is out of stock");
        } elseif ($value > $orderable?->quantity) {
            $fail("The {$attribute} must be less than or equal to {$orderable?->quantity}");
        }
    }
}
