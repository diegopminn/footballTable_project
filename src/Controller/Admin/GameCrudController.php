<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class GameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('blueForward'),
            AssociationField::new('blueDefense'),
            IntegerField::new('blueGols'),
            AssociationField::new('redForward'),
            AssociationField::new('redDefense'),
            IntegerField::new('redGols'),
        ];
    }
}
