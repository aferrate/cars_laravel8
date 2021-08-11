<?php

namespace App\Application\UseCases\User;

use App\Domain\Repository\RoleRepositoryInterface;

class GetCreateInfoUser
{
    private $roleRepository;

    /**
     * GetCreateInfoUser constructor.
     * @param $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return array
     */
    public function getAllRoleNames(): array
    {
        return $this->roleRepository->getAllRoleNames();
    }
}