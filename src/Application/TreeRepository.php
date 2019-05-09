<?php

namespace App\Application;

use App\Entity\Tree;
use Ramsey\Uuid\UuidInterface;

interface TreeRepository
{
    public function get(UuidInterface $id): Tree;

    public function add(Tree $tree): void;

    /**
     * @return Tree[]
     */
    public function findAll(): array ;
}
