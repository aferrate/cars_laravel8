<?php
namespace App\Application\UseCases\Car;

use App\Domain\Model\Car;
use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Photo\PhotoManagerInterface;
use DateTime;
use App\Domain\Repository\CarRepositoryBackupInterface;
use App\Domain\Events\CarUpdatedEvent;
use App\Domain\Cache\CacheInterface;
use App\Application\UseCases\Car\AbstractCarUseCase;

class UpdateCar extends AbstractCarUseCase
{
    private $carRepository;
    private $carRepositoryBackup;
    private $photoManager;
    private $carUpdatedEvent;
    private $cache;

    /**
     * UpdateCar constructor.
     * @param $carRepository
     * @param $carRepositoryBackup
     * @param $photoManager
     * @param $carUpdatedEvent
     * @param $cache
     */
    public function __construct(
        CarRepositoryInterface $carRepository,
        CarRepositoryBackupInterface $carRepositoryBackup,
        PhotoManagerInterface $photoManager,
        CarUpdatedEvent $carUpdatedEvent,
        CacheInterface $cache
    ) {
        $this->carRepository = $carRepository;
        $this->carRepositoryBackup = $carRepositoryBackup;
        $this->photoManager = $photoManager;
        $this->carUpdatedEvent = $carUpdatedEvent;
        $this->cache = $cache;
    }

    /**
     * @return bool
     */
    public function update(array $input, int $authorId, int $id): bool
    {
        $car = $this->returnCarObject($input, $authorId);
        $car->setId($id);
        $car->setImageFilename($input['imageFileOld']);
        $car->setImageFilename($this->managePhoto($input, $this->photoManager));
        $car->setUpdatedAt((new DateTime('NOW'))->format('Y-m-d H:i:s'));

        $this->carRepository->addObserver($this->cache);
        $this->carRepository->update($car);
        $this->carRepository->removeObserver($this->cache);

        $this->carRepositoryBackup->update($car);

        $this->carUpdatedEvent->raise($id);

        return true;
    }
}
