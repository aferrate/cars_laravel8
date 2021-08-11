<?php

namespace App\Application\UseCases\Role;

use App\Domain\Repository\RoleRepositoryInterface;
use App\Domain\Repository\PermissionRepositoryInterface;

class GetEditInfoRole
{
    private $roleRepository;
    private $permissionRepository;

    /**
     * GetAllRoles constructor.
     * @param $roleRepository
     * @param $permissionRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return bool
     */
    public function getEditInfoRole(int $id): array
    {
        $role = $this->roleRepository->findRoleById($id);
        $permissions = $this->permissionRepository->getAllPermissions();
        $permissionsArray = $this->permissionRepository->getArrayRolePermissions($id);

        return [
            'role' => $role,
            'permissions' => $permissions,
            'permissionsArray' => $permissionsArray
        ];
    }
}