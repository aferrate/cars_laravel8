<?php
namespace App\Services\Cache;

use App\Domain\Cache\CacheInterface;
use Illuminate\Support\Facades\Redis;

class CacheRedis implements CacheInterface
{
    public function putIndexCars(array $cars, string $key): void
    {
        Redis::set($key, json_encode($cars), 'EX', 300);
    }

    public function getIndexCars(string $key): string
    {
        $cars = Redis::get($key);

        if (!empty($cars)) {
            return $cars;
        }

        return '';
    }
}
