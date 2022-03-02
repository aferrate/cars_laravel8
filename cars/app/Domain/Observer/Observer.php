<?php
namespace App\Domain\Observer;

interface Observer
{
    /**
     * Handling a new Value
     *
     * @param array $value
     */
    public function newValue(array $value): void;
}
