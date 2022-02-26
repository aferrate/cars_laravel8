<?php
namespace App\Application\UseCases\Car;

use App\Domain\Factory\RepoCarFactory;
use App\Domain\Cache\CacheInterface;

class ListAllCarsEnabled
{
    private $carRepository;
    private $cache;

    /**
     * GetCarInfo constructor.
     * @param $repoCarFactory
     */
    public function __construct(
        RepoCarFactory $repoCarFactory,
        CacheInterface $cache
    ) {
        $this->carRepository = $repoCarFactory->makeRepoCar();
        $this->cache = $cache;
    }

    /**
     * @return array
     */
    public function getCarsEnabled(): string
    {
        $cacheCars = $this->cache->getIndexCars('cars');

        if (!empty($cacheCars)) {
            return $cacheCars;
        }

        $cars = $this->carRepository->findAllEnabled();

        $this->cache->putIndexCars($cars, 'cars');

        return json_encode($cars);
    }
}
