<?php

namespace App\Application\UseCases\User;

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Model\User;

class GetUserInfo
{
    private $userRepository;

    /**
     * GetUserInfo constructor.
     * @param $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array
     */
    public function getUserInfo(int $id): User
    {
        return $this->userRepository->findUserById($id);
    }
}