<?php

namespace App\Tests\Entity;

use App\Entity\UserLeave;
use App\Exception\DuplicateUsernameException;
use PHPUnit\Framework\TestCase;

class UserLeaveTest extends TestCase
{
    public function testUserWithGreaterNameIsStoredInRightNode()
    {
        $userLeave = new UserLeave('B', 1, 2);
        $anotherUser = new UserLeave('C', 3, 4);
        $userLeave->addUser($anotherUser);
        $this->assertSame($anotherUser, $userLeave->rightUser());
    }
    public function testUserWithSmallerNameIsStoredInLeftNode()
    {
        $userLeave = new UserLeave('B', 1, 2);
        $anotherUser = new UserLeave('A', 3, 4);
        $userLeave->addUser($anotherUser);
        $this->assertSame($anotherUser, $userLeave->leftUser());
    }
    public function testUserWithGreaterNameIsStoredInRightNodeAndViceVersa()
    {
        $userLeave = new UserLeave('B', 1, 2);
        $anotherUser = new UserLeave('C', 3, 4);
        $yetAnotherUser = new UserLeave('A', 3, 4);
        $userLeave->addUser($anotherUser);
        $userLeave->addUser($yetAnotherUser);
        $this->assertSame($anotherUser, $userLeave->rightUser());
        $this->assertSame($yetAnotherUser, $userLeave->leftUser());
    }

    public function testUserFindsItselfThenLooksForItsName(){
        $userRoot = new UserLeave('B', 1, 2);
        $this->assertSame($userRoot, $userRoot->find($userRoot->username()));
    }

    public function testUserReturnsAnotherUserIfItIsHisLeaf(){
        $userRoot = new UserLeave('B', 1, 2);
        $anotherUser = new UserLeave('C', 3, 4);
        $yetAnotherUser = new UserLeave('A', 3, 4);
        $userRoot->addUser($anotherUser);
        $userRoot->addUser($yetAnotherUser);

        $this->assertSame($userRoot, $userRoot->find($userRoot->username()));
        $this->assertSame($anotherUser, $userRoot->find($anotherUser->username()));
        $this->assertSame($yetAnotherUser, $userRoot->find($yetAnotherUser->username()));
    }

    public function testUserThrowsExceptionWhenThereIsAlreadyUserWithThatUsername() {
        $userRoot = new UserLeave('John Doe', 1, 2);
        $anotherUser = new UserLeave('John Doe', 3, 4);

        $this->expectException(DuplicateUsernameException::class);

        $userRoot->addUser($anotherUser);
    }
}
