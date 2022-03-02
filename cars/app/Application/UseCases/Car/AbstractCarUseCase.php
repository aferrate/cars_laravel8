<?php
namespace App\Application\UseCases\Car;

use App\Domain\Model\Car;
use App\Domain\Photo\PhotoManagerInterface;

abstract class AbstractCarUseCase
{
    protected function returnCarObject(array $input, int $authorId): Car
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

        return $car;
    }

    protected function managePhoto(array $input, PhotoManagerInterface $photoManager): string
    {
        if (isset($input['imageFile']) && !isset($input['defImg'])) {
            if (isset($input['imageFileOld'])) {
                $photoManager->deleteOldPhoto($input['imageFileOld']);
            }

            $fileName = $photoManager->uploadCarImage(['image' => $input['imageFile']]);

            return $fileName;
        }

        if (isset($input['defImg'])) {
            $photoManager->deleteOldPhoto($input['imageFileOld']);
        }

        return 'no-photo.jpg';
    }
}
