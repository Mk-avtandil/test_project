<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\OrderPlaced' => [
            'App\Listeners\RecordOrderDetails',
        ],
    ];
}
