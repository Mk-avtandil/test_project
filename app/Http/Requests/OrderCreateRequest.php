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
            'status' => ['required', Rule::in(Order::STATUSES)],
            'orderables' => ['required', 'array', new CheckQuantity($this->orderables)],
            'orderables.*.orderable_id' => ['required'],
            'orderables.*.orderable_type' => ['required', 'string', 'in:product,service'],
            'orderables.*.quantity' => ['required', 'integer']
        ];
    }
}
