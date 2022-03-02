<?php
namespace App\Application\UseCases\User;

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Repository\RoleRepositoryInterface;

class GetEditInfoUser
{
    private $userRepository;
    private $roleRepository;

    /**
     * GetEditInfoUser constructor.
     * @param $userRepository
     * @param $roleRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return array
     */
    public function getEditInfoUser(int $id): array
    {
        $user = $this->userRepository->findUserById($id);
        $roles = $this->roleRepository->getAllRoleNames();
        $userRole = $user->getRoleNames();

        return [
            'user' => $user,
            'roles' => $roles,
            'userRole' => $userRole
        ];
    }
}
