<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardUserController extends AbstractController
{
    #[Route('/dashboardUser/{id}', name: 'app_dashboard_user')]
    public function index($id, UserRepository $userRepo): Response
    {
         $datas = $userRepo->findAll();

        return $this->render('dashboard_user/dashboardUser.html.twig', [
            'controller_name' => 'DashboardUserController',
            'datas' => $datas,
        ]);
    }
}
