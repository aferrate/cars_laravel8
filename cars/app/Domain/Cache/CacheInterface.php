<?php
namespace App\Domain\Cache;

interface CacheInterface
{
    public function putIndexCars(array $cars, string $key): void;

    public function getIndexCars(string $key): string;
}
