<?php
namespace App\Domain\Repository;

use App\Domain\Model\Role;

interface RoleRepositoryInterface
{
    public function getAllRoles(): array;

    public function createRole(array $input): void;

    public function findRoleById(int $id): Role;

    public function updateRole(array $input, int $id): void;

    public function deleteRole(int $id): void;

    public function getAllRoleNames(): array;
}
