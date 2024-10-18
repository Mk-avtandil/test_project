<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(Order::STATUSES)],
        ];
    }
}
