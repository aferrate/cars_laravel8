<?php

namespace App\Application\UseCases\Car;

use App\Domain\Model\Car;
use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Photo\PhotoManagerInterface;
use DateTime;
use App\Domain\Repository\CarRepositoryBackupInterface;
use App\Domain\Events\CarUpdatedEvent;

class UpdateCar
{
    private $carRepository;
    private $carRepositoryBackup;
    private $photoManager;

    /**
     * UpdateCar constructor.
     * @param $carRepository
     * @param $carRepositoryBackup
     * @param $photoManager
     * @param $carUpdatedEvent
     */
    public function __construct(
        CarRepositoryInterface $carRepository,
        CarRepositoryBackupInterface $carRepositoryBackup,
        PhotoManagerInterface $photoManager,
        CarUpdatedEvent $carUpdatedEvent
    )
    {
        $this->carRepository = $carRepository;
        $this->carRepositoryBackup = $carRepositoryBackup;
        $this->photoManager = $photoManager;
        $this->carUpdatedEvent = $carUpdatedEvent;
    }

    /**
     * @return bool
     */
    public function update(array $input, int $authorId, int $id): bool
    {
        $enabled = (isset($input['enabled'])) ? true : false;

        $car = new Car();
        $car->setId($id);
        $car->setMark($input['mark']);
        $car->setModel($input['model']);
        $car->setYear($input['year']);
        $car->setDescription($input['description']);
        $car->setCountry($input['country']);
        $car->setCity($input['city']);
        $car->setEnabled($enabled);
        $car->setAuthorId($authorId);
        $car->setImageFilename($input['imageFileOld']);
        $car->setImageFilename($this->managePhoto($input));
        $car->setUpdatedAt((new DateTime('NOW'))->format('Y-m-d H:i:s'));

        $this->carRepository->update($car);
        $this->carRepositoryBackup->update($car);
        $this->carUpdatedEvent->raise($id);

        return true;
    }

    private function managePhoto(array $input)
    {
        if(isset($input['imageFile']) && !isset($input['defImg'])) {
            $this->photoManager->deleteOldPhoto($input['imageFileOld']);

            $fileName = $this->photoManager->uploadCarImage(['image' => $input['imageFile']]);

            return $fileName;
        }

        if(isset($input['defImg'])) {
            $this->photoManager->deleteOldPhoto($input['imageFileOld']);
        }

        return 'no-photo.jpg';
    }
}