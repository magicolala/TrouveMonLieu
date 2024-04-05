<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use App\Entity\City;
use App\Entity\User;

class DashboardController extends AbstractDashboardController
{
  #[Route('/admin', name: 'admin')]
  public function index(): Response
  {
    return $this->render('admin/dashboard.html.twig');
  }

  public function configureDashboard(): Dashboard
  {
    return Dashboard::new()
      ->setTitle('Administration TML');
  }

  public function configureMenuItems(): iterable
  {
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('Villes', 'fas fa-city', City::class);
    yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
    // Ajoutez d'autres éléments de menu pour les autres entités
  }
}
