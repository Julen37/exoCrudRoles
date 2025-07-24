<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
final class DashboardAdminController extends AbstractController
{
    #[Route('/dashboardAdmin', name: 'app_dashboard_admin')] 
    #[IsGranted("ROLE_ADMIN")]
    public function index(UserRepository $userRepo): Response
    {
        $datas = $userRepo->findAll();

        return $this->render('dashboard_admin/dashboardAdmin.html.twig', [
            'controller_name' => 'DashboardAdminController',
            'datas' => $datas,
        
        ]);
    }
}
