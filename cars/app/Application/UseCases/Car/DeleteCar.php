<?php
namespace App\Application\UseCases\Car;

use App\Domain\Model\Car;
use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Repository\CarRepositoryBackupInterface;
use App\Domain\Photo\PhotoManagerInterface;
use App\Domain\Events\CarDeletedEvent;

class DeleteCar
{
    private $carRepository;
    private $carRepositoryBackup;
    private $photoManager;

    /**
     * DeleteCar constructor.
     * @param $carRepository
     * @param $carRepositoryBackup
     * @param $photoManager
     * @param $carDeletedEvent
     */
    public function __construct(
        CarRepositoryInterface $carRepository,
        CarRepositoryBackupInterface $carRepositoryBackup,
        PhotoManagerInterface $photoManager,
        CarDeletedEvent $carDeletedEvent
    ) {
        $this->carRepository = $carRepository;
        $this->carRepositoryBackup = $carRepositoryBackup;
        $this->photoManager = $photoManager;
        $this->carDeletedEvent = $carDeletedEvent;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete(int $carId, string $imageName): bool
    {
        $this->photoManager->deleteOldPhoto($imageName);

        $this->carRepository->delete($carId);
        $this->carRepositoryBackup->delete($carId);
        $this->carDeletedEvent->raise($carId);

        return true;
    }
}
