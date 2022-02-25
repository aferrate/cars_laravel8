<?php
namespace App\Application\UseCases\Car;

use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Repository\CarRepositoryBackupInterface;
use App\Domain\Cache\CacheInterface;

class ListAllCarsEnabled
{
    private $carRepository;
    private $carRepositoryBackup;
    private $cache;

    /**
     * GetCarInfo constructor.
     * @param $carRepository
     * @param $carRepositoryBackup
     */
    public function __construct(
        CarRepositoryInterface $carRepository,
        CarRepositoryBackupInterface $carRepositoryBackup,
        CacheInterface $cache
    ) {
        $this->carRepository = $carRepository;
        $this->carRepositoryBackup = $carRepositoryBackup;
        $this->cache = $cache;
    }

    /**
     * @return array
     */
    public function getCarsEnabled(bool $backupEnabled): string
    {
        $cacheCars = $this->cache->getIndexCars('cars');

        if (!empty($cacheCars)) {
            return $cacheCars;
        }

        $cars = ($backupEnabled) ? $this->carRepositoryBackup->findAllEnabled() : $this->carRepository->findAllEnabled();

        $this->cache->putIndexCars($cars, 'cars');

        return json_encode($cars);
    }
}
