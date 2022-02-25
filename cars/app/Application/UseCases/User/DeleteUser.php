<?php
namespace App\Application\UseCases\User;

use App\Domain\Repository\UserRepositoryInterface;

class DeleteUser
{
    private $userRepository;

    /**
     * DeleteUser constructor.
     * @param $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return void
     */
    public function delete(int $id): void
    {
        $this->userRepository->deleteUser($id);
    }
}
