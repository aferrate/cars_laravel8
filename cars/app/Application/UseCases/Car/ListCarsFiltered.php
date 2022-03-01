<?php
namespace App\Application\UseCases\Car;

use App\Domain\Criteria\Criteria;
use App\Domain\Factory\RepoCarFactory;
use App\Application\Query\Car\SearchEnabledCarsQuery;

class ListCarsFiltered
{
    private $carRepository;

    /**
     * ListCarsFiltered constructor.
     * @param $repoCarFactory
     */
    public function __construct(RepoCarFactory $repoCarFactory)
    {
        $this->carRepository = $repoCarFactory->makeRepoCar();
    }

    /**
     * @return array
     */
    public function getCarsFiltered(array $searchParams, bool $isAdmin): string
    {
        $criteria = new Criteria(
            $this->carRepository->translateFilter(
            $searchParams['field'],
            $searchParams['search']
        ),
            'desc'
        );

        $cars = $this->carRepository->searchByCriteria($criteria, $isAdmin);

        return json_encode($cars);
    }
}
