<?php
namespace App\Domain\Factory;

use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Repository\CarRepositoryBackupInterface;

class RepoCarFactory
{
    private $carRepository;
    private $carRepositoryBackup;

    /**
     * RepoCarFactory constructor.
     * @param $carRepository
     * @param $carRepositoryBackup
     */
    public function __construct(CarRepositoryInterface $carRepository, CarRepositoryBackupInterface $carRepositoryBackup)
    {
        $this->carRepository = $carRepository;
        $this->carRepositoryBackup = $carRepositoryBackup;
    }

    /**
     * @return CarRepositoryInterface|CarRepositoryBackupInterface
     */
    public function makeRepoCar(): CarRepositoryInterface|CarRepositoryBackupInterface
    {
        switch (env('USE_BACKUP_REPO')) {
            case true:
                $carRepo = $this->carRepositoryBackup;
                break;
            case false:
                $carRepo = $this->carRepository;
                break;
        }

        return $carRepo;
    }
}
