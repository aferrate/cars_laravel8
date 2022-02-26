<?php
namespace App\Eloquent\Repositories;

use App\Domain\Repository\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;
use App\Domain\Model\Permission as PermissionDomain;
use Illuminate\Database\Eloquent\Collection;
use DB;

class EloquentPermissionRepository implements PermissionRepositoryInterface
{
    public function getAllPermissions(): array
    {
        return $this->returnPermissionsDomain(Permission::get());
    }

    public function getRolePermissions(int $id): array
    {
        $permissionsEntity = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)->get();

        $permissions = $this->returnPermissionsDomain($permissionsEntity);

        return $permissions;
    }

    public function getArrayRolePermissions(int $id): array
    {
        return DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
    }

    private function returnPermissionsDomain(Collection $permissionsEntity): array
    {
        $permissions = [];

        foreach ($permissionsEntity as $permissionEntity) {
            $permission = new PermissionDomain();
            $permission->setId($permissionEntity->id);
            $permission->setName($permissionEntity->name);
            $permissions[] = $permission;
        }

        return $permissions;
    }
}
