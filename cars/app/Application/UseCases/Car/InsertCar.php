<?php
namespace App\Application\UseCases\Car;

use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Model\Car;
use DateTime;
use App\Domain\Repository\CarRepositoryBackupInterface;
use App\Domain\Photo\PhotoManagerInterface;
use App\Domain\Events\CarCreatedEvent;

class InsertCar
{
    private $carRepository;
    private $carRepositoryBackup;
    private $photoManager;

    /**
     * InsertCar constructor.
     * @param $carRepository
     * @param $carRepositoryBackup
     * @param $photoManager
     * @param $carCreatedEvent
     */
    public function __construct(
        CarRepositoryInterface $carRepository,
        CarRepositoryBackupInterface $carRepositoryBackup,
        PhotoManagerInterface $photoManager,
        CarCreatedEvent $carCreatedEvent
    ) {
        $this->carRepository = $carRepository;
        $this->carRepositoryBackup = $carRepositoryBackup;
        $this->photoManager = $photoManager;
        $this->carCreatedEvent = $carCreatedEvent;
    }

    /**
     * @return bool
     */
    public function insert(array $input, int $authorId): bool
    {
        $enabled = (isset($input['enabled'])) ? true : false;

        $car = new Car();
        $car->setMark($input['mark']);
        $car->setModel($input['model']);
        $car->setYear($input['year']);
        $car->setDescription($input['description']);
        $car->setCountry($input['country']);
        $car->setCity($input['city']);
        $car->setEnabled($enabled);
        $car->setAuthorId($authorId);
        $car->setImageFilename($this->managePhoto($input));
        $car->setCreatedAt((new DateTime('NOW'))->format('Y-m-d H:i:s'));
        $car->setUpdatedAt((new DateTime('NOW'))->format('Y-m-d H:i:s'));
        $car->setSlug(uniqid());

        $id = $this->carRepository->save($car);

        $car->setId($id);

        $this->carRepositoryBackup->save($car);
        $this->carCreatedEvent->raise($id);

        return true;
    }

    private function managePhoto(array $input)
    {
        $fileName = 'no-photo.jpg';

        if (isset($input['imageFile'])) {
            $fileName = $this->photoManager->uploadCarImage(['image' => $input['imageFile']]);
        }

        return $fileName;
    }
}
