<?php

namespace App\Application\UseCases\Car;

use App\Domain\Repository\CarRepositoryBackupInterface;

class DeleteElasticIndexForCars
{
    private $carRepositoryBackup;

    /**
     * GetCarInfo constructor.
     * @param $carRepositoryBackup
     */
    public function __construct(CarRepositoryBackupInterface $carRepositoryBackup)
    {
        $this->carRepositoryBackup = $carRepositoryBackup;
    }

    /**
     * @return void
     */
    public function deleteIndexCars(): void
    {
        $this->carRepositoryBackup->deleteIndexCars();
    }
}
