<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Rules\CheckQuantity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'orderable_type' => ['required', 'string', 'in:product,service'],
            'orderable_id' => ['required', 'integer'],
            'status' => ['required', Rule::in(Order::STATUSES)],
            'quantity' => [
                Rule::excludeIf(fn() => $this->orderable_type !== 'product'),
                'required',
                'integer',
                new CheckQuantity($this->orderable_type, $this->orderable_id)
            ]
        ];
    }
}
