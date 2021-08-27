<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ToDoListController extends AbstractController
{
    private $security;
    
    public function __construct(Security $sec)
    {
        $this->security = $sec;
    }
    
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

    #[Route('/my-tasks', name: 'myTasks')]
    public function myTasks(): Response
    {  
        if($this->security->getUser()===null)
            return $this->redirectToRoute('app_login');
        return $this->render('ToDoList/index.html.twig', [
            'controller_name' => 'ToDoListContollerController',
        ]);
    }
}
