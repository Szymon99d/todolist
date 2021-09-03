<?php

namespace App\Services;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class CheckCategoryName{
    
    private $em;
    private $security;
    public function __construct(EntityManagerInterface $em,Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function checkRecords(Category $category): bool
    {
        if($this->em->getRepository(Category::class)->findOneBy([
            'categoryName'=>$category->getCategoryName(),'user'=>$this->security->getUser()
        ]))
            return true;
        else return false;
    }
}




?>