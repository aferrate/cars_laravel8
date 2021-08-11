<?php

namespace App\Application\UseCases\Role;

use App\Domain\Repository\RoleRepositoryInterface;

class InsertRole
{
    private $roleRepository;

    /**
     * GetAllRoles constructor.
     * @param $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return bool
     */
    public function inserRole(array $input): void
    {
        $this->roleRepository->createRole($input);
    }
}