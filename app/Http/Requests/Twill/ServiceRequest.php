<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class ServiceRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'type' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:1', 'max:10000000'],
            'deadline' => ['required', 'date'],
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'type' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:1', 'max:10000000'],
            'deadline' => ['required', 'date'],
        ];
    }
}
