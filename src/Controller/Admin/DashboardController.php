<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Tournament;
use App\Entity\Division;
use App\Entity\Player;

use App\Controller\Admin\PlayerCrudController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(PlayerCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TennisTournamentTest');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Home', 'fa fa-home');
        
        yield MenuItem::subMenu('Inscriptions', 'fa fa-list')->setSubItems([
            MenuItem::linkToCrud('Tournament', 'fas fa-cash-register', Tournament::class),
            MenuItem::linkToCrud('Divisions', 'fas fa-cash-register', Division::class),
            MenuItem::linkToCrud('Players', 'fas fa-cash-register', Player::class),
        ]);
    }
}
