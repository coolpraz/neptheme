<?php

namespace Coolpraz\NepTheme;

use Illuminate\Support\ServiceProvider;

class NepThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__.'/../config/theme.php';

        // Publish config.
        $this->publishes([
            $configPath => config_path('theme.php')
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('neptheme.themes', function () {
            return new Theme();
        });
    }
}
