<?php

namespace App\Domain\Repository;

use App\Domain\Criteria\Criteria;
use App\Domain\Model\Car;

interface CarRepositoryBackupInterface
{
    public function findBySlug(string $slug): Car;
    public function save(Car $car): void;
    public function delete(int $carId): void;
    public function findAllEnabled(int $limit = 0, int $offset = 0): array;
    public function findAll(): array;
    public function searchByCriteria(Criteria $criteria, bool $isAdmin): array;
    public function findOneById($id): Car;
}