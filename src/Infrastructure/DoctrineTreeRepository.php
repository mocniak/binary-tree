<?php

namespace App\Infrastructure;

use App\Application\TreeRepository;
use App\Entity\Tree;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class DoctrineTreeRepository implements TreeRepository
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Tree::class);
    }

    public function get(UuidInterface $id): Tree
    {
        $this->repository->find($id);
    }

    public function add(Tree $tree): void
    {
        $this->entityManager->persist($tree);
    }

    public function __destruct()
    {
        $this->entityManager->flush();
    }

    /**
     * @return Tree[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}
