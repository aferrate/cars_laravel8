<?php
namespace App\Services\Cache;

use App\Domain\Cache\CacheInterface;
use App\Domain\Model\Car;
use Illuminate\Support\Facades\Redis;

class CacheRedis implements CacheInterface
{
    public function putIndexCar(Car $car, string $key): void
    {
        Redis::set($key, json_encode($car));
    }

    public function getIndexCar(string $key): string
    {
        $cars = Redis::get($key);

        if (!empty($car)) {
            return $car;
        }

        return '';
    }
}
