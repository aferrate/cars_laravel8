<?php

namespace App\Application\UseCases\User;

use App\Domain\Repository\UserRepositoryInterface;

class InsertUser
{
    private $userRepository;

    /**
     * InsertUser constructor.
     * @param $roleRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return void
     */
    public function insertUser(array $input): void
    {
        $this->userRepository->createUser($input);
    }
}