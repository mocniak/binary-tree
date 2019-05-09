<?php

namespace App\Controller;

use App\Application\TreeRepository;
use App\Application\TreeService;
use PragmaRX\Random\Random;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TreeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(TreeRepository $repository)
    {
        return $this->render('index.html.twig', [
            'trees' => $repository->findAll()
        ]);
    }


    /**
     * @Route("/add-tree", name="add-tree")
     */
    public function addTree(TreeService $treeService)
    {
        $treeService->addEmptyTree();
        return $this->redirectToRoute('homepage');
    }
    /**
     * @Route("/add-random-user/{id}", name="add-random-user")
     */
    public function addRandomUser(string $id, TreeService $treeService)
    {
        $treeService->addUserToTree(Uuid::fromString($id), (new Random())->get(), 12, 31);

//        return $this->redirectToRoute('homepage');
    }

}
