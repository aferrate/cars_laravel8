<?php
namespace App\Domain\Observer;

abstract class Observable
{
    private $observers = [];

    /**
     * Add an Observer to the $observers Array
     *
     * @param Observer $observer
     */
    final public function addObserver(Observer $observer): void
    {
        if (!in_array($observer, $this->observers)) {
            array_push($this->observers, $observer);
        }
    }

    /**
     * Remove an Observer from the $observers Array
     *
     * @param Observer $observer
     */
    final public function removeObserver(Observer $observer): void
    {
        unset($this->observers[array_search($observer, $this->observers)]);
    }

    /**
     * Notify all Observers about a new Value
     *
     * @param array $value
     */
    final protected function notifyObserver(array $value): void
    {
        foreach ($this->observers as $observer) {
            $observer->newValue($value);
        }
    }
}
