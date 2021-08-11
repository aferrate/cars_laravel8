<?php

namespace App\Domain\Repository;

use App\Domain\Model\User;

interface UserRepositoryInterface
{
    public function getAllUsers(): array;
    public function createUser(array $input): void;
    public function findUserById(int $id): User;
    public function updateUser(array $input, int $id): void;
    public function deleteUser(int $id): void;
    public function getEmailUsers(): array;
}