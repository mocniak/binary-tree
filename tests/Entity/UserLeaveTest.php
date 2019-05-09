<?php

namespace App\Tests\Entity;

use App\Entity\UserLeaf;
use App\Exception\DuplicateUsernameException;
use PHPUnit\Framework\TestCase;

class UserLeaveTest extends TestCase
{
    public function testUserWithGreaterNameIsStoredInRightNode()
    {
        $userLeave = new UserLeaf('B', 1, 2);
        $anotherUser = new UserLeaf('C', 3, 4);
        $userLeave->addUser($anotherUser);
        $this->assertSame($anotherUser, $userLeave->rightLeaf());
    }

    public function testUserWithSmallerNameIsStoredInLeftNode()
    {
        $userLeave = new UserLeaf('B', 1, 2);
        $anotherUser = new UserLeaf('A', 3, 4);
        $userLeave->addUser($anotherUser);
        $this->assertSame($anotherUser, $userLeave->leftLeaf());
    }

    public function testUserWithGreaterNameIsStoredInRightNodeAndViceVersa()
    {
        $userLeave = new UserLeaf('B', 1, 2);
        $anotherUser = new UserLeaf('C', 3, 4);
        $yetAnotherUser = new UserLeaf('A', 3, 4);
        $userLeave->addUser($anotherUser);
        $userLeave->addUser($yetAnotherUser);
        $this->assertSame($anotherUser, $userLeave->rightLeaf());
        $this->assertSame($yetAnotherUser, $userLeave->leftLeaf());
    }

    public function testUserFindsItselfThenLooksForItsName()
    {
        $userRoot = new UserLeaf('B', 1, 2);
        $this->assertSame($userRoot, $userRoot->find($userRoot->username()));
    }

    public function testUserReturnsAnotherUserIfItIsHisLeaf()
    {
        $userRoot = new UserLeaf('B', 1, 2);
        $anotherUser = new UserLeaf('C', 3, 4);
        $yetAnotherUser = new UserLeaf('A', 3, 4);
        $userRoot->addUser($anotherUser);
        $userRoot->addUser($yetAnotherUser);

        $this->assertSame($userRoot, $userRoot->find($userRoot->username()));
        $this->assertSame($anotherUser, $userRoot->find($anotherUser->username()));
        $this->assertSame($yetAnotherUser, $userRoot->find($yetAnotherUser->username()));
    }

    public function testUserThrowsExceptionWhenThereIsAlreadyUserWithThatUsername()
    {
        $userRoot = new UserLeaf('John Doe', 1, 2);
        $anotherUser = new UserLeaf('John Doe', 3, 4);

        $this->expectException(DuplicateUsernameException::class);

        $userRoot->addUser($anotherUser);
    }
}
