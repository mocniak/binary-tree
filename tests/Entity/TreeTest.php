<?php

namespace App\Tests\Entity;

use App\Entity\Tree;
use App\Exception\UserNotFoundException;
use PHPUnit\Framework\TestCase;

class TreeTest extends TestCase
{
    public function testTreeStoresUsers()
    {
        $tree = new Tree();
        $username = 'John Doe';
        $leftCredits = 123;
        $rightCredits = 321;
        $tree->addUser($username, $leftCredits, $rightCredits);
        $retrievedUser = $tree->getUser($username);
        $this->assertEquals($retrievedUser->leftCredits(), $leftCredits);
        $this->assertEquals($retrievedUser->rightCredits(), $rightCredits);
    }

    /** @dataProvider manyUsersProvider */
    public function testTreeStoresManyUsers($usersToStore)
    {
        $tree = new Tree();
        foreach ($usersToStore as $user) {
            $tree->addUser($user[0], $user[1], $user[2]);
        }
        foreach ($usersToStore as $user) {
            $retrievedUser = $tree->getUser($user[0]);
            $this->assertEquals($user[1], $retrievedUser->leftCredits());
            $this->assertEquals($user[2], $retrievedUser->rightCredits());
        }
    }

    public function manyUsersProvider()
    {
        return [
            [[
                ['UserA', 12, 13],
                ['UserB', 14, 15],
            ]],
            [[
                ['UserA', 12, 131],
                ['UserB', 131, 5031],
                ['UserC', 122, 231],
                ['UserD', 124, 731],
                ['UserAB', 172, 531],
                ['UserBA', 129, 331],
                ['UserC1', 124, 31],
            ]]];
    }

    public function testTreeThrowsExceptionWhenUserIsNotFound()
    {
        $tree = new Tree();
        $username = 'John Not Found';
        $this->expectException(UserNotFoundException::class);
        $tree->getUser($username);
    }
}
