<?php
namespace App\Application\UseCases\Car;

use App\Domain\Model\Car;
use App\Domain\Factory\RepoCarFactory;
use App\Domain\Cache\CacheInterface;

class GetCarInfo
{
    private $carRepository;

    /**
     * GetCarInfo constructor.
     * @param $repoCarFactory
     * @param $cache
     */
    public function __construct(RepoCarFactory $repoCarFactory, CacheInterface $cache)
    {
        $this->carRepository = $repoCarFactory->makeRepoCar();
        $this->cache = $cache;
    }

    /**
     * @return Car
     */
    public function getCarDetails(string $slug): Car
    {
        $cacheCar = $this->cache->getIndexCar($slug);

        if (!empty($cacheCar)) {
            return Car::returnCarDomain(json_decode($cacheCar, true));
        }

        $car = $this->carRepository->findBySlug($slug);

        return $car;
    }

    /**
     * @return Car
     */
    public function getCarFromId(int $id): Car
    {
        return $this->carRepository->findOneById($id);
    }
}
