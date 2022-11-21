<?php

namespace App\Controller\Admin;

use App\Entity\Playerr;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlayerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Playerr::class;
    }
}
