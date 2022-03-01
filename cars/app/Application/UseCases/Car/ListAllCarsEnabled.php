<?php
namespace App\Application\UseCases\Car;

use App\Domain\Factory\RepoCarFactory;
use App\Domain\Cache\CacheInterface;

class ListAllCarsEnabled
{
    private $carRepository;
    private $cache;

    /**
     * ListAllCarsEnabled constructor.
     * @param $repoCarFactory
     */
    public function __construct(RepoCarFactory $repoCarFactory)
    {
        $this->carRepository = $repoCarFactory->makeRepoCar();
    }

    /**
     * @return array
     */
    public function getCarsEnabled(): string
    {
        $cars = $this->carRepository->findAllEnabled();

        return json_encode($cars);
    }
}
