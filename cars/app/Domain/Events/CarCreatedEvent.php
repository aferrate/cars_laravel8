<?php
namespace App\Domain\Events;

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Queue\QueueInterface;

class CarCreatedEvent
{
    public function __construct(UserRepositoryInterface $userRepositoryInterface, QueueInterface $queueInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->queueInterface = $queueInterface;
    }

    public function raise(int $id): void
    {
        $users = $this->userRepositoryInterface->getEmailUsers();
        $msg = "Car created with id $id.";
        $subject = 'Car created';

        foreach ($users as $user) {
            $payload = '{"id":"' . $id . '", "email":"' . $user . '", "subject":"' . $subject . '", "message":"' . $msg . '"}';
            $this->queueInterface->publish($payload);
        }

        $this->queueInterface->consume();
    }
}
