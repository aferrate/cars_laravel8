<?php
namespace App\Application\UseCases\Role;

use App\Domain\Repository\RoleRepositoryInterface;
use App\Domain\Repository\PermissionRepositoryInterface;

class GetRoleInfo
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
    public function getRoleInfo(int $id): array
    {
        $role = $this->roleRepository->findRoleById($id);
        $rolePermissions = $this->permissionRepository->getRolePermissions($id);

        return ['role' => $role, 'rolePermissions' => $rolePermissions, ];
    }
}
