<?php

namespace App\Application;

use App\Entity\Tree;
use Ramsey\Uuid\UuidInterface;

class TreeService
{
    private $repository;

    public function __construct(TreeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function addEmptyTree() {
        $this->repository->add(new Tree());
    }

    public function addUserToTree(UuidInterface $treeId, $username, $leftCredits, $rightCredits){
        $tree = $this->repository->get($treeId);
        $tree->addUser($username, $leftCredits, $rightCredits);
    }
}
