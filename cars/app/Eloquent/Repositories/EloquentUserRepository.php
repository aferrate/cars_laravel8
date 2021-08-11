<?php

namespace App\Eloquent\Repositories;

use App\Domain\Repository\UserRepositoryInterface;
use App\Models\User;
use App\Domain\Model\User as UserDomain;
use DB;
use Hash;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function getAllUsers(): array
    {
        $users = [];
        $usersEntity = User::orderBy('id','DESC')->get();

        foreach($usersEntity as $userEntity) {
            $user = new UserDomain();
            $user->setId($userEntity->id);
            $user->setName($userEntity->name);
            $user->setEmail($userEntity->email);
            $user->setRoleNames($userEntity->getRoleNames()->toArray());
            $users[] = $user;
        }

        return $users;
    }

    public function createUser(array $input): void
    {
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($input['roles']);
    }

    public function findUserById(int $id): UserDomain
    {
        $userEntity = User::find($id);

        $user = new UserDomain();
        $user->setId($userEntity->id);
        $user->setName($userEntity->name);
        $user->setEmail($userEntity->email);
        $user->setRoleNames($userEntity->getRoleNames()->toArray());

        return $user;
    }

    public function updateUser(array $input, int $id): void
    {
        if(!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($input['roles']);
    }

    public function deleteUser(int $id): void
    {
        User::find($id)->delete();
    }

    public function getEmailUsers(): array
    {
        return User::pluck('email')->toArray();
    }
}
