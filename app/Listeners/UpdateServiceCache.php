<?php

namespace App\Listeners;

use App\Models\Service;
use Illuminate\Support\Facades\Cache;

class UpdateServiceCache
{
    public function handle(Service $service): void
    {
        Cache::forget('all_services');
        Cache::put('all_services', Service::all(), 60);
    }
}
