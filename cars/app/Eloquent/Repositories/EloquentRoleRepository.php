<?php
namespace App\Eloquent\Repositories;

use App\Domain\Repository\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;
use App\Domain\Model\Role as RoleDomain;
use DB;

class EloquentRoleRepository implements RoleRepositoryInterface
{
    public function getAllRoles(): array
    {
        $roles = [];
        $rolesEntity = Role::orderBy('id', 'DESC')->get();

        foreach ($rolesEntity as $roleEntity) {
            $role = new RoleDomain();
            $role->setId($roleEntity->id);
            $role->setName($roleEntity->name);
            $roles[] = $role;
        }

        return $roles;
    }

    public function createRole(array $input): void
    {
        $role = Role::create(['name' => $input['name']]);
        $role->syncPermissions($input['permission']);
    }

    public function findRoleById(int $id): RoleDomain
    {
        $roleEntity = Role::find($id);

        $role = new RoleDomain();
        $role->setId($roleEntity->id);
        $role->setName($roleEntity->name);

        return $role;
    }

    public function updateRole(array $input, int $id): void
    {
        $role = Role::find($id);
        $role->name = $input['name'];
        $role->save();
        $role->syncPermissions($input['permission']);
    }

    public function deleteRole(int $id): void
    {
        DB::table('roles')->where('id', $id)->delete();
    }

    public function getAllRoleNames(): array
    {
        return Role::pluck('name', 'name')->all();
    }
}
