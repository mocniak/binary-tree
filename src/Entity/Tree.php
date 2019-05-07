<?php

namespace App\Entity;

use App\Exception\UserNotFoundException;

class Tree
{
    /** @var UserLeave|null */
    private $rootUser;

    public function __construct()
    {
        $this->rootUser = null;
    }

    public function getLeaves()
    {
        return [];
    }

    public function addUser(string $username, int $leftCredits, int $rightCredits)
    {
        $newUser = new UserLeave($username, $leftCredits, $rightCredits);
        if ($this->rootUser === null) {
            $this->rootUser = $newUser;
        } else {
            $this->rootUser->addUser($newUser);
        }
    }

    public function getUser(string $username): UserLeave
    {
        if ($this->rootUser === null) {
            throw new UserNotFoundException();
        }
        return $this->rootUser->find($username);
    }
}
