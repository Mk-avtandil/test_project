<?php

namespace App\Providers;

use A17\Twill\Facades\TwillAppSettings;
use A17\Twill\Services\Settings\SettingsGroup;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        TwillAppSettings::registerSettingsGroup(
            SettingsGroup::make()->name('homepage')->label('Homepage')
        );
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
              return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
          });
        Relation::enforceMorphMap([
            'product' => 'App\Models\Product',
            'service' => 'App\Models\Service',
            'page' => 'App\Models\Page',
            'order' => 'App\Models\Order',
            'app_settings' => 'A17\Twill\Models\AppSetting',
            'user' => 'App\Models\User',
            'menu_link' => 'App\Models\MenuLink',
            'comment' => 'App\Models\Comment',
        ]);
    }
}
