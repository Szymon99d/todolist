<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoListContollerController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(): Response
    {
        return $this->render('ToDoList/index.html.twig', [
            'controller_name' => 'ToDoListContollerController',
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(): Response
    {  
        return $this->render('ToDoList/index.html.twig', [
            'controller_name' => 'ToDoListContollerController',
        ]);
    }
}
