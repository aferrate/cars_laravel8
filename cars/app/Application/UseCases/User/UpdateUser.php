<?php

namespace App\Application\UseCases\User;

use App\Domain\Repository\UserRepositoryInterface;

class UpdateUser
{
    private $userRepository;

    /**
     * UpdateCar constructor.
     * @param $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return bool
     */
    public function update(array $input, int $id): void
    {
        $this->userRepository->updateUser($input, $id);
    }
}