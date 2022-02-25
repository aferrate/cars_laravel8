<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SendMailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Domain\Mail\SendMailInterface',
            'App\Services\Mail\SendMail'
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
