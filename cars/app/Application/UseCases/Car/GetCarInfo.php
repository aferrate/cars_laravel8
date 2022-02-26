<?php
namespace App\Application\UseCases\Car;

use App\Domain\Model\Car;
use App\Domain\Factory\RepoCarFactory;

class GetCarInfo
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
     * @return Car
     */
    public function getCarDetails(string $slug): Car
    {
        return $this->carRepository->findBySlug($slug);
    }

    /**
     * @return Car
     */
    public function getCarFromId(int $id): Car
    {
        return $this->carRepository->findOneById($id);
    }
}
