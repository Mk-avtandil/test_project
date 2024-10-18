<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot() {
        Gate::define('list-products', function ($user) {
            return $user->hasPermission('list-products');
        });
    }
}
