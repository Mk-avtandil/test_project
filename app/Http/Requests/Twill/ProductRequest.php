<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class ProductRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'type' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:100'],
            'size' => ['required', 'integer', 'min:1', 'max:10000'],
            'price' => ['required', 'integer', 'min:1', 'max:10000000'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100000'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'type' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:100'],
            'size' => ['required', 'integer', 'min:1', 'max:10000'],
            'price' => ['required', 'integer', 'min:1', 'max:10000000'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100000'],
            'description' => ['nullable', 'string'],
        ];
    }
}
