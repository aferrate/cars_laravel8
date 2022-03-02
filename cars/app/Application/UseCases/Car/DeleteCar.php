<?php
namespace App\Application\UseCases\Car;

use App\Domain\Model\Car;
use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Repository\CarRepositoryBackupInterface;
use App\Domain\Photo\PhotoManagerInterface;
use App\Domain\Events\CarDeletedEvent;
use App\Domain\Cache\CacheInterface;
use App\Application\UseCases\Car\AbstractCarUseCase;

class DeleteCar
{
    private $carRepository;
    private $carRepositoryBackup;
    private $photoManager;
    private $carDeletedEvent;
    private $cache;

    /**
     * DeleteCar constructor.
     * @param $carRepository
     * @param $carRepositoryBackup
     * @param $photoManager
     * @param $carDeletedEvent
     * @param $cache
     */
    public function __construct(
        CarRepositoryInterface $carRepository,
        CarRepositoryBackupInterface $carRepositoryBackup,
        PhotoManagerInterface $photoManager,
        CarDeletedEvent $carDeletedEvent,
        CacheInterface $cache
    ) {
        $this->carRepository = $carRepository;
        $this->carRepositoryBackup = $carRepositoryBackup;
        $this->photoManager = $photoManager;
        $this->carDeletedEvent = $carDeletedEvent;
        $this->cache = $cache;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete(int $carId, string $imageName): bool
    {
        $this->photoManager->deleteOldPhoto($imageName);

        $this->carRepository->addObserver($this->cache);
        $this->carRepository->delete($carId);
        $this->carRepository->removeObserver($this->cache);

        $this->carRepositoryBackup->delete($carId);

        $this->carDeletedEvent->raise($carId);

        return true;
    }
}
