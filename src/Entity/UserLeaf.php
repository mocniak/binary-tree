<?php

namespace App\Entity;

use App\Exception\DuplicateUsernameException;

final class UserLeaf
{
    private $username;
    private $leftCredits;
    private $rightCredits;
    /** @var null|UserLeaf */
    private $rightLeaf;
    /** @var null|UserLeaf */
    private $leftLeaf;

    public function __construct(string $username, int $leftCredits, int $rightCredits)
    {
        $this->username = $username;
        $this->leftCredits = $leftCredits;
        $this->rightCredits = $rightCredits;
        $this->rightLeaf = null;
        $this->leftLeaf = null;
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

    public function find(string $username): ?UserLeaf
    {
        if ($this->username === $username) {
            return $this;
        }
        if ($this->rightLeaf !== null) {
            $rightResult = $this->rightLeaf->find($username);
            if ($rightResult !== null) return $rightResult;
        }
        if ($this->leftLeaf !== null) {
            $leftResult = $this->leftLeaf->find($username);
            if ($leftResult !== null) return $leftResult;
        }
        return null;
    }

    /**
     * @param UserLeaf $newUser
     * @throws DuplicateUsernameException
     */
    public function addUser(UserLeaf $newUser)
    {
        if ($newUser->username === $this->username) {
            throw new DuplicateUsernameException();
        } elseif (strcmp($newUser->username, $this->username) < 0) {
            if ($this->leftLeaf !== null) {
                $this->leftLeaf->addUser($newUser);
            } else {
                $this->leftLeaf = $newUser;
            }
        } elseif (strcmp($newUser->username, $this->username) > 0) {
            if ($this->rightLeaf !== null) {
                $this->rightLeaf->addUser($newUser);
            } else {
                $this->rightLeaf = $newUser;
            }
        }
    }

    public function rightUser(): ?UserLeaf
    {
        return $this->rightLeaf;
    }

    public function leftUser()
    {
        return $this->leftLeaf;
    }
}
