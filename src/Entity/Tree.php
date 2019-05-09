<?php

namespace App\Entity;

use App\Exception\UserNotFoundException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Tree
{
    /** @var UserLeaf|null */
    private $rootUser;

    private $id;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->rootUser = null;
    }

    public function addUser(string $username, int $leftCredits, int $rightCredits)
    {
        $newUser = new UserLeaf($username, $leftCredits, $rightCredits);
        if ($this->rootUser === null) {
            $this->rootUser = $newUser;
        } else {
            $this->rootUser->addUser($newUser);
        }
    }

    public function getUser(string $username): UserLeaf
    {
        if ($this->rootUser === null) {
            throw new UserNotFoundException();
        }
        return $this->rootUser->find($username);
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function rootUser(): ?UserLeaf
    {
        return $this->rootUser;
    }
}
