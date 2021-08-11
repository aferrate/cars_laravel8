<?php

namespace App\Application\UseCases\Car;

use App\Domain\Criteria\Criteria;
use App\Domain\Repository\CarRepositoryInterface;
use App\Application\Query\Car\SearchEnabledCarsQuery;
use App\Domain\Repository\CarRepositoryBackupInterface;

class ListCarsFiltered
{
    private $carRepository;
    private $carRepositoryBackup;

    /**
     * GetCarInfo constructor.
     * @param $carRepository
     */
    public function __construct(CarRepositoryInterface $carRepository, CarRepositoryBackupInterface $carRepositoryBackup)
    {
        $this->carRepository = $carRepository;
        $this->carRepositoryBackup = $carRepositoryBackup;
    }

    /**
     * @return array
     */
    public function getCarsFiltered(array $searchParams, bool $isAdmin, bool $backupEnabled): string
    {
        if($backupEnabled) {
            $criteria = new Criteria($this->carRepositoryBackup->translateFilter(
                    $searchParams['field'],
                    $searchParams['search']
                ),
                'desc'
            );

            $cars = $this->carRepositoryBackup->searchByCriteria($criteria, $isAdmin);
        } else {
            $criteria = new Criteria($this->carRepository->translateFilter(
                    $searchParams['field'],
                    $searchParams['search']
                ),
                'desc'
            );

            $cars = $this->carRepository->searchByCriteria($criteria, $isAdmin);
        }

        return json_encode($cars);
    }
}
