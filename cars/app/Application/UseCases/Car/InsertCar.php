<?php
namespace App\Application\UseCases\Car;

use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Model\Car;
use DateTime;
use App\Domain\Repository\CarRepositoryBackupInterface;
use App\Domain\Photo\PhotoManagerInterface;
use App\Domain\Events\CarCreatedEvent;
use App\Domain\Cache\CacheInterface;
use App\Application\UseCases\Car\AbstractCarUseCase;

class InsertCar extends AbstractCarUseCase
{
    private $carRepository;
    private $carRepositoryBackup;
    private $photoManager;
    private $carCreatedEvent;
    private $cache;

    /**
     * InsertCar constructor.
     * @param $carRepository
     * @param $carRepositoryBackup
     * @param $photoManager
     * @param $carCreatedEvent
     * @param $cache
     */
    public function __construct(
        CarRepositoryInterface $carRepository,
        CarRepositoryBackupInterface $carRepositoryBackup,
        PhotoManagerInterface $photoManager,
        CarCreatedEvent $carCreatedEvent,
        CacheInterface $cache
    ) {
        $this->carRepository = $carRepository;
        $this->carRepositoryBackup = $carRepositoryBackup;
        $this->photoManager = $photoManager;
        $this->carCreatedEvent = $carCreatedEvent;
        $this->cache = $cache;
    }

    /**
     * @return bool
     */
    public function insert(array $input, int $authorId): bool
    {
        $car = $this->returnCarObject($input, $authorId);
        $car->setImageFilename($this->managePhoto($input, $this->photoManager));
        $car->setCreatedAt((new DateTime('NOW'))->format('Y-m-d H:i:s'));
        $car->setUpdatedAt((new DateTime('NOW'))->format('Y-m-d H:i:s'));
        $car->setSlug(uniqid());

        $this->carRepository->addObserver($this->cache);

        $id = $this->carRepository->save($car);

        $this->carRepository->removeObserver($this->cache);

        $car->setId($id);

        $this->carRepositoryBackup->save($car);
        $this->carCreatedEvent->raise($id);

        return true;
    }
}
