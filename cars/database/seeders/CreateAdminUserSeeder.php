<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'test1',
            'email' => 'test1@test.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $user = User::create([
            'name' => 'test2',
            'email' => 'test2@test.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::create(['name' => 'User']);
        $permissions = [];

        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
