<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Task;
use App\Entity\User;
use App\Form\CreateCategoryType;
use App\Form\CreateTaskType;
use App\Form\RegisterUserType;
use App\Services\CheckCategoryName;
use App\Services\CheckUserAuthentication;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class ToDoListController extends AbstractController
{
    private $security;
    private $em;
    private $checkUserAuth;
    public function __construct(Security $security, EntityManagerInterface $em, CheckUserAuthentication $checkUserAuth)
    {
        $this->security = $security;
        $this->em = $em;
        $this->checkUserAuth = $checkUserAuth;
    }
    
    #[Route('/', name: 'main')]
    public function index(): Response
    {
        
        return $this->render('ToDoList/index.html.twig', [
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $passHasher): Response
    {  
        $newUser = new User;
        $form = $this->createForm(RegisterUserType::class,$newUser,[]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $newUser->setUsername($form->get('username')->getData());
            $newUser->setPassword($passHasher->hashPassword($newUser,$form->get('password')->getData()));
            $newUser->setEmail($form->get('email')->getData());
            $this->em->persist($newUser);
            $this->em->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('Security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/my-tasks', name: 'myTasks')]
    public function myTasks(Request $request, CheckCategoryName $checkCategoryName): Response
    {  
        if($this->checkUserAuth->checkUserAuth())
            return $this->redirectToRoute('register');

        $newCategory = new Category();
        $categoryForm = $this->createForm(CreateCategoryType::class,$newCategory,[]);
        $categoryForm->handleRequest($request);
        if($categoryForm->isSubmitted() && $categoryForm->isValid())
        {
            if($checkCategoryName->checkRecords($categoryForm->getData()))
            {
                $this->addFlash('warn','Podana nazwa kategorii już istnieje!');
                return $this->redirectToRoute('myTasks');
            }   
            
            $newCategory->setCategoryName($categoryForm->get('categoryName')->getData());
            $newCategory->setUser($this->security->getUser());
            $this->em->persist($newCategory);
            $this->em->flush($newCategory);
            return $this->redirectToRoute('myTasks');
        }

        $categories = $this->em->getRepository(Category::class)->findBy(['user'=>$this->security->getUser()]);

        return $this->render('ToDoList/myTasks.html.twig', [
            'categoryForm'=>$categoryForm->createView(),
            'categories'=>$categories,
        ]);
    }

    #[Route('/my-tasks/{categoryId}/{categoryName}',name: 'taskBrowser')]
    public function browseMyTasks(Category $categoryId, Request $request)
    {
        if($this->checkUserAuth->checkUserAuthData($categoryId))
        return $this->redirectToRoute('main');

        $task = new Task();
        $taskForm = $this->createForm(CreateTaskType::class,$task,[]);
        $taskForm->handleRequest($request);
        if($taskForm->isSubmitted() && $taskForm->isValid())
        {
            $task->setGoal($taskForm->get('goal')->getData());
            $task->setStatus(false);
            $task->setCategory($categoryId);
            $task->setUser($this->security->getUser());
            $this->em->persist($task);
            $this->em->flush($task);
            return $this->redirectToRoute('taskBrowser',['categoryId'=>$categoryId->getId(),'categoryName'=>$categoryId->getCategoryName()]);
        }
            
            
        return $this->render("ToDoList/taskBrowser.html.twig",[
            'categoryId'=>$categoryId,
            'taskForm'=>$taskForm->createView(),
        ]);
        
    }

    #[Route('/delete/category/{categoryId}',name: 'deleteCategory')]
    public function deleteCategory(Category $categoryId): Response
    {
        if($this->checkUserAuth->checkUserAuthData($categoryId))
            return $this->redirectToRoute('main');

        $this->em->remove($categoryId);
        $this->em->flush();
        return $this->redirectToRoute('myTasks');
    }

    #[Route('/delete/task/{taskId}',name: 'deleteTask')]
    public function deleteTask(Task $taskId): Response
    {
        $currentCategory = $taskId->getCategory();
        if($this->checkUserAuth->checkUserAuthData($taskId))
            return $this->redirectToRoute('main');

        $this->em->remove($taskId);
        $this->em->flush();
        return $this->redirectToRoute('taskBrowser',[
        'categoryId'=>$currentCategory->getId(),'categoryName'=>$currentCategory->getCategoryName()
        ]);
    }
    #[Route('/update/task/{taskId}',name: 'updateTask')]
    public function updateTask(Task $taskId,Request $request): Response
    {
        $currentCategory = $taskId->getCategory();
        if($this->checkUserAuth->checkUserAuthData($taskId))
            return $this->redirectToRoute('main');
                
        $taskId->setStatus(!$taskId->getStatus());
        $this->em->persist($taskId);
        $this->em->flush();
                
        return $this->redirectToRoute('taskBrowser',[
        'categoryId'=>$currentCategory->getId(),'categoryName'=>$currentCategory->getCategoryName()
        ]);

    }
}
