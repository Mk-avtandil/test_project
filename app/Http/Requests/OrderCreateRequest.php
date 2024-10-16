<?php

namespace App\Http\Requests;
use App\Models\Order;
use App\Models\Product;
use App\Rules\CheckQuantity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderCreateRequest extends FormRequest
{
    public function rules(): array
    {
        $orderable = $this->orderable_type::find($this->orderable_id);

        return [
            'orderable_type' => ['required', 'string'],
            'orderable_id' => ['required', 'integer'],

            'status' => ['required', Rule::in(Order::STATUSES)],
            'quantity' => [
                Rule::excludeIf($this->orderable_type !== 'App\\Models\\Product'),
                'required',
                'integer',
                new CheckQuantity($orderable)
            ]
        ];
    }
}
