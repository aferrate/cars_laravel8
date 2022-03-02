<?php
namespace App\Domain\Model;

use JsonSerializable;

final class Car implements JsonSerializable
{
    private $id;
    private $mark;
    private $model;
    private $year;
    private $description;
    private $slug;
    private $enabled;
    private $createdAt;
    private $updatedAt;
    private $country;
    private $city;
    private $imageFilename;
    private $authorId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getMark(): string
    {
        return $this->mark;
    }

    /**
     * @param string $mark
     */
    public function setMark(string $mark): void
    {
        $this->mark = $mark;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return bool
     */
    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getImageFilename(): string
    {
        return $this->imageFilename;
    }

    /**
     * @param string $imageFilename
     */
    public function setImageFilename(string $imageFilename): void
    {
        $this->imageFilename = $imageFilename;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'mark' => $this->mark,
            'model' => $this->model,
            'year' => $this->year,
            'description' => $this->description,
            'slug' => $this->slug,
            'enabled' => $this->enabled,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'country' => $this->country,
            'city' => $this->city,
            'imageFilename' => $this->imageFilename,
            'authorId' => $this->authorId,
        ];
    }

    public static function returnCarDomain(array $carArr): Car
    {
        $car = new Car();

        $car->setId($carArr['id']);
        $car->setMark($carArr['mark']);
        $car->setModel($carArr['model']);
        $car->setYear($carArr['year']);
        $car->setDescription($carArr['description']);
        $car->setSlug($carArr['slug']);
        $car->setEnabled($carArr['enabled']);
        $car->setCountry($carArr['country']);
        $car->setCity($carArr['city']);
        $car->setImageFilename($carArr['imageFilename']);
        $car->setCreatedAt($carArr['createdAt']);
        $car->setUpdatedAt($carArr['updatedAt']);
        $car->setAuthorId($carArr['authorId']);

        return $car;
    }
}
