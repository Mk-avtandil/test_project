<?php

namespace App\Http\Requests;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    public function rules(): array
    {
        $orderable = $this->orderable_type::find($this->orderable_id);
        $rules = [
            'user_id' => ['required', 'exists:users,id'],
            'orderable_type' => ['required', 'string'],
            'orderable_id' => ['required', 'integer'],

            'status' => ['required', function ($attribute, $value, $fail) {
                if (!in_array($value, ['pending', 'completed'])) {
                    $fail("$attribute can be only completed or pending");
                }
            }],
        ];
        if ($orderable instanceof Product) {
            $rules['quantity'] = [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($orderable) {
                    if ($orderable->quantity == 0) {
                        $fail("The Product '{$orderable->type}' is out of stock");
                    }
                    if ($value > $orderable->quantity) {
                        $fail("The {$attribute} must be less than or equal to {$orderable->quantity}");
                    }
                }];
        }

        return $rules;
    }
}
