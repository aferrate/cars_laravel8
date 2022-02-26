<?php
namespace App\Application\UseCases\Car;

use App\Domain\Factory\RepoCarFactory;

class ListAllCars
{
    private $carRepository;

    /**
     * GetCarInfo constructor.
     * @param $repoCarFactory
     */
    public function __construct(RepoCarFactory $repoCarFactory)
    {
        $this->carRepository = $repoCarFactory->makeRepoCar();
    }

    /**
     * @return array
     */
    public function findAllCars(): string
    {
        return json_encode($this->carRepository->findAll());
    }
}
