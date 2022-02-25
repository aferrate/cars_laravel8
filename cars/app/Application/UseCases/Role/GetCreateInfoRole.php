<?php
namespace App\Application\UseCases\Role;

use App\Domain\Repository\PermissionRepositoryInterface;

class GetCreateInfoRole
{
    private $permissionRepository;

    /**
     * GetAllRoles constructor.
     * @param $permissionRepository
     */
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return bool
     */
    public function getPermissions(): array
    {
        return $this->permissionRepository->getAllPermissions();
    }
}
