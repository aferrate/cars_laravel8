<?php

namespace App\Application\UseCases\Role;

use App\Domain\Repository\RoleRepositoryInterface;

class UpdateRole
{
    private $roleRepository;

    /**
     * UpdateCar constructor.
     * @param $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return void
     */
    public function update(array $input, int $id): void
    {
        $this->roleRepository->updateRole($input, $id);
    }
}