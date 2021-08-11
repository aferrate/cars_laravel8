<?php

namespace App\Domain\Events;

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Queue\QueueInterface;

class CarUpdatedEvent
{
    public function __construct(UserRepositoryInterface $userRepositoryInterface, QueueInterface $queueInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->queueInterface = $queueInterface;
    }

    public function raise(int $id)
    {
        $users = $this->userRepositoryInterface->getEmailUsers();
        $msg = "Car updated with id $id.";
        $subject = 'Car updated';

        foreach($users as $user) {
            $payload = '{"id":"'.$id.'", "email":"'.$user.'", "subject":"'.$subject.'", "message":"'.$msg.'"}';
            $this->queueInterface->publish($payload);
        }
        
        $this->queueInterface->consume();
    }
}
