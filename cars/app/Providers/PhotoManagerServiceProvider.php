<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PhotoManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Domain\Photo\PhotoManagerInterface',
            'App\Services\Photo\PhotoManager'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
