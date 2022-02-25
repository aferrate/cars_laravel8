<?php
namespace App\Services\Queue;

use  App\Domain\Queue\QueueInterface;
use App\Domain\Mail\SendMailInterface;
use Amqp;

class QueueRabbitmq implements QueueInterface
{
    public function __construct(SendMailInterface $sendMailInterface)
    {
        $this->sendMailInterface = $sendMailInterface;
    }

    public function publish(string $payload): void
    {
        Amqp::publish(
            'default',
            $payload,
            ['queue' => 'default', 'exchange' => 'default']
        );
    }

    public function consume(): void
    {
        Amqp::consume('default', function ($message, $resolver) {
            $this->sendMailInterface->sendMail(json_decode($message->body, true));

            $resolver->acknowledge($message);
            $resolver->stopWhenProcessed();
        });
    }
}
