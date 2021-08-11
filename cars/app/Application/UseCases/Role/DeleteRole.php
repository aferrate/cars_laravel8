<?php

namespace App\Application\UseCases\Role;

use App\Domain\Repository\RoleRepositoryInterface;

class DeleteRole
{
    private $roleRepository;

    /**
     * UpdateCar constructor.
     * @param $carRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return bool
     */
    public function delete(int $id): void
    {
        $this->roleRepository->deleteRole($id);
    }
}