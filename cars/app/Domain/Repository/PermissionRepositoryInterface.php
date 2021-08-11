<?php

namespace App\Domain\Repository;

interface PermissionRepositoryInterface
{
    public function getAllPermissions(): array;
    public function getRolePermissions(int $id): array;
}