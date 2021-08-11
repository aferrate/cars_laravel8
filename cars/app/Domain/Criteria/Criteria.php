<?php

namespace App\Domain\Criteria;

class Criteria
{
    private $filters;
    private $order;

    /**
     * Criteria constructor.
     */
    public function __construct(array $filters, string $order)
    {
        $this->filters = $filters;
        $this->order = $order;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @return bool
     */
    public function hasFilters(): bool
    {
        return count($this->filters) > 0;
    }

    public function hasOrder(): bool
    {
        return null !== $this->order;
    }
}