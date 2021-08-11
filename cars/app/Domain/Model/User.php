<?php

namespace App\Domain\Model;

final class User
{
    private $id;
    private $name;
    private $email;
    private $roleNames;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return array
     */
    public function getRoleNames(): array
    {
        return $this->roleNames;
    }

    /**
     * @param array $email
     */
    public function setRoleNames(array $roleNames): void
    {
        $this->roleNames = $roleNames;
    }
}