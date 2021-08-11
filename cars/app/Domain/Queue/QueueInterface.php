<?php

namespace App\Domain\Queue;

interface QueueInterface
{
    public function publish(string $payload): void;
    public function consume(): void;
}