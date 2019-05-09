<?php

namespace App\Controller;

use App\Application\TreeRepository;
use App\Application\TreeService;
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
     * @Route("/add-random-user", name="add-random-user")
     */
    public function addRandomUser()
    {

        return $this->render('index.html.twig', [

        ]);
    }

}
