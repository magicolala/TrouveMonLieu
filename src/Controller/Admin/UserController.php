<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
}
