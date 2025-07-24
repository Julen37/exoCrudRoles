<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardUserController extends AbstractController
{
    #[Route('/dashboardUser', name: 'app_dashboard_user')]
    public function index(): Response
    {
        return $this->render('dashboard_user/dashboardUser.html.twig', [
            'controller_name' => 'DashboardUserController',
        ]);
    }
}
