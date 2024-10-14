<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;


class OrderCreateRequest extends FormRequest
{
    public function rules(): array
    {
        $orderable = $this->orderable_type::find($this->orderable_id);
        return [
            'user_id' => ['required', 'exists:users,id'],
            'orderable_type' => ['required', 'string'],
            'orderable_id' => ['required', 'integer'],

            'status' => ['required', function ($attribute, $value, $fail) {
            if (!in_array($value, ['pending', 'completed'])) {
                    $fail("$attribute can be only pending or completed");
                }
            }],

            'quantity' => ['required', 'integer', function ($attribute, $value, $fail) use ($orderable) {
                if ($orderable->quantity == 0) {
                    $fail("The Product or Service '{$orderable->type}' is out of stock");
                }
                if ($value > $orderable->quantity) {
                    $fail("The {$attribute} must be less than or equal to {$orderable->quantity}");
                }
            }],// TODO:: надо поменять для App\\Models\\Service
        ];
    }
}
