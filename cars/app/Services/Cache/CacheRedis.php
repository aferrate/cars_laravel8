<?php
namespace App\Services\Cache;

use App\Domain\Cache\CacheInterface;
use App\Domain\Model\Car;
use App\Domain\Observer\Observer;
use Illuminate\Support\Facades\Redis;

class CacheRedis implements CacheInterface, Observer
{
    public function putIndexCar(array $car, string $key): void
    {
        Redis::set($key, json_encode($car));
    }

    public function getIndexCar(string $key): string
    {
        $car = Redis::get($key);

        if (!empty($car)) {
            return $car;
        }

        return '';
    }

    public function deleteIndexCar(string $key): void
    {
        Redis::del($key);
    }

    /**
     * Handling a new Value
     *
     * @param array $value
     */
    public function newValue(array $value): void
    {
        switch ($value['type']) {
            case 'insert':
                $this->putIndexCar($value['car']->jsonSerialize(), $value['car']->getSlug());
                break;
            case 'update':
                $this->deleteIndexCar($value['car']->getSlug());
                $this->putIndexCar($value['car']->jsonSerialize(), $value['car']->getSlug());
                break;
            case 'delete':
                $this->deleteIndexCar($value['car']);
                break;
        }
    }
}
