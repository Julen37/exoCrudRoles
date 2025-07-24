<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(UserRepository $userRepo): Response
    {

        return $this->render('home_page/homePage.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
}
