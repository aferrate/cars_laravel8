<?php
namespace App\Domain\Cache;

use App\Domain\Model\Car;

interface CacheInterface
{
    public function putIndexCar(array $car, string $key): void;

    public function getIndexCar(string $key): string;
}
