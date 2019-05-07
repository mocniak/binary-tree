<?php

namespace App\Entity;

use App\Exception\DuplicateUsernameException;

class UserLeave
{
    private $username;
    private $leftCredits;
    private $rightCredits;
    /** @var null|UserLeave */
    private $rightLeave;
    /** @var null|UserLeave */
    private $leftLeave;

    public function __construct(string $username, int $leftCredits, int $rightCredits)
    {
        $this->username = $username;
        $this->leftCredits = $leftCredits;
        $this->rightCredits = $rightCredits;
        $this->rightLeave = null;
        $this->leftLeave = null;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function leftCredits(): int
    {
        return $this->leftCredits;
    }

    public function rightCredits(): int
    {
        return $this->rightCredits;
    }

    public function find(string $username): ?UserLeave
    {
        if ($this->username === $username) {
            return $this;
        }
        if ($this->rightLeave !== null) {
            $rightResult = $this->rightLeave->find($username);
            if ($rightResult !== null) return $rightResult;
        }
        if ($this->leftLeave !== null) {
            $leftResult = $this->leftLeave->find($username);
            if ($leftResult !== null) return $leftResult;
        }
        return null;
    }

    /**
     * @param UserLeave $newUser
     * @throws DuplicateUsernameException
     */
    public function addUser(UserLeave $newUser)
    {
        if ($newUser->username === $this->username) {
            throw new DuplicateUsernameException();
        } elseif (strcmp($newUser->username, $this->username) < 0) {
            if ($this->leftLeave !== null) {
                $this->leftLeave->addUser($newUser);
            } else {
                $this->leftLeave = $newUser;
            }
        } elseif (strcmp($newUser->username, $this->username) > 0) {
            if ($this->rightLeave !== null) {
                $this->rightLeave->addUser($newUser);
            } else {
                $this->rightLeave = $newUser;
            }
        }
    }

    public function rightUser(): ?UserLeave
    {
        return $this->rightLeave;
    }

    public function leftUser()
    {
        return $this->leftLeave;
    }
}
