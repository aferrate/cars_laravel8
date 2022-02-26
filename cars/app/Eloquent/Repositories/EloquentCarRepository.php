<?php
namespace App\Eloquent\Repositories;

use App\Domain\Repository\CarRepositoryInterface;
use App\Models\Car as CarEntity;
use App\Domain\Model\Car;
use App\Domain\Criteria\Criteria;
use App\Eloquent\TranslateFilterEloquent;

class EloquentCarRepository implements CarRepositoryInterface
{
    private $carModel;

    public function __construct(CarEntity $carModel)
    {
        $this->carModel = $carModel;
    }

    public function findAllEnabled(int $limit = 0, int $offset = 0): array
    {
        $cars = $this->carModel->selectRaw('*')
            ->whereRaw('enabled = 1')
            ->orderByRaw('id desc')
            ->get()
            ->toArray()
        ;

        return $cars;
    }

    public function findAll(): array
    {
        $cars = $this->carModel->selectRaw('*')
            ->orderByRaw('id desc')
            ->get()
            ->toArray()
        ;

        return $cars;
    }

    public function searchByCriteria(Criteria $criteria, bool $isAdmin): array
    {
        $whereRawSQL = '';

        if ($criteria->hasFilters()) {
            $filters = $criteria->getFilters();

            foreach ($filters as $filter) {
                $whereRawSQL .= $filter;
            }
        }

        if (!$isAdmin) {
            $prefix = ($whereRawSQL == '') ? ' ' : ' and ';
            $whereRawSQL .= $prefix . 'enabled = 1';
        }

        $carsModel = $this->carModel->selectRaw('*');

        if ($whereRawSQL !== '') {
            $carsModel = $carsModel->whereRaw($whereRawSQL);
        }

        $cars = $carsModel->orderByRaw(($criteria->getOrder() == 'desc') ? 'id desc' : 'id asc')->get()->toArray();

        return $cars;
    }

    public function findOneById($id): Car
    {
        $carModel = $this->carModel->firstWhere('id', $id);

        if (is_null($carModel)) {
            $car = new Car();
            $car->setId(0);

            return $car;
        }

        return $this->returnCarDomain($carModel);
    }

    public function findBySlug(string $slug): Car
    {
        $carModel = $this->carModel->firstWhere('slug', $slug);

        if (is_null($carModel)) {
            $car = new Car();
            $car->setId(0);

            return $car;
        }

        return $this->returnCarDomain($carModel);
    }

    public function save(Car $car): int
    {
        $id = $this->carModel->create([
            'mark' => $car->getMark(),
            'model' => $car->getModel(),
            'year' => $car->getYear(),
            'description' => $car->getDescription(),
            'slug' => $car->getSlug(),
            'enabled' => $car->getEnabled(),
            'country' => $car->getCountry(),
            'city' => $car->getCity(),
            'image_filename' => $car->getImageFilename(),
            'created_at' => $car->getCreatedAt(),
            'updated_at' => $car->getUpdatedAt(),
            'author_id' => $car->getAuthorId(),
        ])->id;

        return $id;
    }

    public function update(Car $car): void
    {
        $carEntity = CarEntity::find($car->getId());
        $carEntity->mark = $car->getMark();
        $carEntity->model = $car->getModel();
        $carEntity->year = $car->getYear();
        $carEntity->description = $car->getDescription();
        $carEntity->enabled = $car->getEnabled();
        $carEntity->country = $car->getCountry();
        $carEntity->city = $car->getCity();
        $carEntity->image_filename = $car->getImageFilename();
        $carEntity->updated_at = $car->getUpdatedAt();
        $carEntity->author_id = $car->getAuthorId();
        $carEntity->save();
    }

    public function delete(int $carId): void
    {
        $this->carModel->destroy($carId);
    }

    private function returnCarDomain(CarEntity $carModel): Car
    {
        $car = new Car();

        $car->setId($carModel->id);
        $car->setMark($carModel->mark);
        $car->setModel($carModel->model);
        $car->setYear($carModel->year);
        $car->setDescription($carModel->description);
        $car->setSlug($carModel->slug);
        $car->setEnabled($carModel->enabled);
        $car->setCountry($carModel->country);
        $car->setCity($carModel->city);
        $car->setImageFilename($carModel->image_filename);
        $car->setCreatedAt($carModel->created_at);
        $car->setUpdatedAt($carModel->updated_at);
        $car->setAuthorId($carModel->author_id);

        return $car;
    }

    public function translateFilter(string $field, string $stringToSearch): array
    {
        return TranslateFilterEloquent::translateFilter($field, $stringToSearch);
    }
}
