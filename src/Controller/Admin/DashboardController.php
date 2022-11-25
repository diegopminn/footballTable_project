<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Entity\Player;
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
     * @var string
     */
    private string $dashboardTitleImage;

    /**
     * @var string
     */
    private string $dashboardFavicon;

    /**
     * @param string $dashboardTitleImage
     * @param string $dashboardFavicon
     */
    public function __construct ( string $dashboardTitleImage, string $dashboardFavicon )
    {
        $this->dashboardTitleImage = $dashboardTitleImage;
        $this->dashboardFavicon = $dashboardFavicon;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index (): Response
    {
        $adminUrlGenerator = $this->container->get( AdminUrlGenerator::class );

        return $this->redirect( $adminUrlGenerator->setController( GameCrudController::class )->generateUrl() );
    }

    public function configureDashboard (): Dashboard
    {
        $titleImagInn = sprintf( '<img src="%s" alt"Logo">', $this->dashboardTitleImage );
        $favimg = sprintf( '<img src="%s" alt"Favicon">', $this->dashboardFavicon );
        return Dashboard::new()
            ->setTitle( $titleImagInn )
            ->setFaviconPath( $favimg )
            ->setTextDirection( 'ltr' );
    }

    public function configureMenuItems (): iterable
    {
        return [
            MenuItem::section( 'Players' ),
                MenuItem::linkToCrud( 'Crear Player', 'fas fa-plus', Player::class )->setAction( Crud::PAGE_NEW ),
                MenuItem::linkToCrud( 'Ver Players', 'fas fa-eye', Player::class ),
            MenuItem::section( 'Users' ),
                 MenuItem::linkToCrud( 'Ver Usuarios', 'fas fa-eye', User::class ),
            MenuItem::section( 'Games' ),
                MenuItem::linkToCrud( 'Crear Partido', 'fas fa-plus', Game::class )->setAction( Crud::PAGE_NEW ),
                MenuItem::linkToCrud( 'Ver Partidos', 'fas fa-eye', Game::class ),
        ];
    }
}
