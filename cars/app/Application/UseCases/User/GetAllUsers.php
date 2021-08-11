<?php

namespace App\Application\UseCases\User;

use App\Domain\Repository\UserRepositoryInterface;

class GetAllUsers
{
    private $userRepository;

    /**
     * GetAllUsers constructor.
     * @param $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return bool
     */
    public function getAllUsers(): array
    {
        return $this->userRepository->getAllUsers();
    }
}