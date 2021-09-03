<?php

namespace App\Services;

use App\Entity\Category;
use App\Entity\Task;
use Symfony\Component\Security\Core\Security;

class CheckUserAuthentication{

    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public function checkUserAuth(): bool
    {
        if($this->security->getUser()===null)
            return true;
        else return false;
    }

    public function checkUserData(Category|Task $entity): bool
    {
        if($entity->getUser() != $this->security->getUser())
            return true;
        else return false;
    }

    public function checkUserAuthData(Category|Task $entity): bool
    {
        if(!$this->checkUserAuth() && $this->checkUserData($entity))
            return true;
        else return false;
    }


}


?>