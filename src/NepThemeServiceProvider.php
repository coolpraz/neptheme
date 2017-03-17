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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('neptheme.themes', function () {
            return new \App\Themes();
        });
    }
}
