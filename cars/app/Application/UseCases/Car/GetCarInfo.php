<?php

namespace App\Application\UseCases\Car;

use App\Domain\Model\Car;
use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Repository\CarRepositoryBackupInterface;

class GetCarInfo
{
    private $carRepository;
    private $carRepositoryBackup;

    /**
     * GetCarInfo constructor.
     * @param $carRepository
     * @param $carRepositoryBackup
     */
    public function __construct(CarRepositoryInterface $carRepository, CarRepositoryBackupInterface $carRepositoryBackup)
    {
        $this->carRepository = $carRepository;
        $this->carRepositoryBackup = $carRepositoryBackup;
    }

    /**
     * @return Car
     */
    public function getCarDetails(string $slug, bool $backupEnabled): Car
    {
        $car = ($backupEnabled) ? $this->carRepositoryBackup->findBySlug($slug) : $this->carRepository->findBySlug($slug);

        return $car;
    }

    /**
     * @return Car
     */
    public function getCarFromId(int $id, bool $backupEnabled): Car
    {
        $car = ($backupEnabled) ? $this->carRepositoryBackup->findOneById($id) : $this->carRepository->findOneById($id);

        return $car;
    }
}
