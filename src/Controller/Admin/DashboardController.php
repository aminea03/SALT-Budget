<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Categories;
use App\Entity\Paiements;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('dashboard/dashboard.html.twig');
        
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
        return $this->redirect($adminUrlGenerator->setController(CategoriesCrudController::class)->generateUrl());
        return $this->redirect($adminUrlGenerator->setController(PaiementsCrudController::class)->generateUrl());


    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SALT Budget')
            ->setFaviconPath('<img src="{{ asset(/images/Salt_logo_rond.svg) }}" alt="Logo SALT rond">');
    }

    public function configureMenuItems(): iterable
    {
        
        yield MenuItem::linktoRoute('Accueil du site', 'fas fa-house', 'app_accueil');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-solid fa-users', User::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-section', Categories::class);
        yield MenuItem::linkToCrud('Paiements', 'fas fa-solid fa-hand-holding-dollar', Paiements::class);
        yield MenuItem::linkToLogout('Logout', 'fa-solid fa-door-open');
        
    }
}
