<?php

namespace App\Controller\Admin;

use App\Entity\Playerr;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index (): Response
    {
        $adminUrlGenerator = $this->container->get( AdminUrlGenerator::class );

        return $this->redirect( $adminUrlGenerator->setController( PlayerCrudController::class )->generateUrl() );
    }

    public function configureDashboard (): Dashboard
    {
        return Dashboard::new()
            ->setTitle( 'FootballTable Project' );
    }

    public function configureMenuItems (): iterable
    {
        return [
                MenuItem::linkToCrud( 'Crear Player', 'fas fa-plus', Playerr::class )->setAction( Crud::PAGE_NEW ),
                MenuItem::linkToCrud( 'Ver Players', 'fas fa-eye', Playerr::class ),
                MenuItem::linkToCrud( 'Crear Usuario', 'fas fa-plus', User::class )->setAction( Crud::PAGE_NEW ),
                MenuItem::linkToCrud( 'Ver Usuario', 'fas fa-eye', User::class ),
        ];
    }
}
