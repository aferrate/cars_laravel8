<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Domain\Repository\CarRepositoryInterface',
            'App\Eloquent\Repositories\EloquentCarRepository'
        );
        $this->app->bind(
            Client::class,
            function ($app) {
                return ClientBuilder::create()->setHosts(['host' => 'elasticsearch:9200'])->build();
            }
        );
        $this->app->bind(
            'App\Domain\Repository\CarRepositoryBackupInterface',
            'App\ElasticSearch\Repositories\ElasticSearchCarRepository'
        );
        $this->app->bind(
            'App\Domain\Repository\UserRepositoryInterface',
            'App\Eloquent\Repositories\EloquentUserRepository'
        );
        $this->app->bind(
            'App\Domain\Repository\RoleRepositoryInterface',
            'App\Eloquent\Repositories\EloquentRoleRepository'
        );
        $this->app->bind(
            'App\Domain\Repository\PermissionRepositoryInterface',
            'App\Eloquent\Repositories\EloquentPermissionRepository'
        );
        $this->app->bind(
            'App\Domain\Queue\QueueInterface',
            'App\Services\Queue\QueueRabbitmq'
        );
        $this->app->bind(
            'App\Domain\Cache\CacheInterface',
            'App\Services\Cache\CacheRedis'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
