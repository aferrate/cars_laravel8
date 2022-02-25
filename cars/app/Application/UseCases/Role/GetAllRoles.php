<?php
namespace App\Application\UseCases\Role;

use App\Domain\Repository\RoleRepositoryInterface;

class GetAllRoles
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
    public function getAllRoles(): array
    {
        return $this->roleRepository->getAllRoles();
    }
}
