<?php
namespace App\Application\UseCases\Car;

use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Repository\CarRepositoryBackupInterface;

class ListAllCars
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
     * @return array
     */
    public function findAllCars(bool $backupEnabled): string
    {
        $cars = ($backupEnabled) ? $this->carRepositoryBackup->findAll() : $this->carRepository->findAll();

        return json_encode($cars);
    }
}
