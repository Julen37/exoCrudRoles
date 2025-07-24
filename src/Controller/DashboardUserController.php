<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    //UPDATE USER
    #[Route('/update/{id}', name: 'app_home_page_registerUpdate')] 
    public function update_form($id, Request $request, EntityManagerInterface $entityManager): Response 
    {
        $crud = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(RegistrationFormType::class, $crud, ['is_registration' => false]); 
        $form->handleRequest($request);
        if  ( $form->isSubmitted() && $form->isValid()){ 
            $entityManager->persist($crud);
            $entityManager->flush(); 

            $this->addFlash('notice', 'Edit successfull !');

            return $this->redirectToRoute('app_home_page'); 
        }

        return $this->render('registration/registerUpdate.html.twig', [ 
            'registrationForm' => $form->createView()
        ]);
    }

    //DELETE
    #[Route('/delete/{id}', name: 'app_home_page_registerDelete')] 
    public function delete_form($id, EntityManagerInterface $entityManager): Response 
    {
        $crud = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($crud); 
        $entityManager->flush(); 

        $this->addFlash('notice', 'Deletation successfull !');

        return $this->redirectToRoute('app_home_page'); 
    }

}
