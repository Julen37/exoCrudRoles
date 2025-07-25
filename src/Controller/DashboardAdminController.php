<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    //UPDATE ADMIN
    #[Route('/update/{id}', name: 'app_home_page_registerUpdateAdmin')] 
    #[IsGranted("ROLE_ADMIN")]
    public function update_form($id, Request $request, EntityManagerInterface $entityManager): Response 
    {
        $crud = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(RegistrationFormType::class, $crud, ['is_registration' => false]); 
        $form->handleRequest($request);
        if  ( $form->isSubmitted() && $form->isValid()){ 
            $entityManager->persist($crud);
            $entityManager->flush(); 

            $this->addFlash('notice', 'Edit successfull !');

            return $this->redirectToRoute('app_dashboard_admin'); 
        }

        return $this->render('registration/registerUpdate.html.twig', [ 
            'registrationForm' => $form->createView()
        ]);
    }

    //DELETE
    #[Route('/delete/{id}', name: 'app_home_page_registerDeleteAdmin')] 
    #[IsGranted("ROLE_ADMIN")]
    public function delete_form($id, EntityManagerInterface $entityManager): Response 
    {
        $crud = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($crud); 
        $entityManager->flush(); 

        $this->addFlash('notice', 'Deletation successfull !');

        return $this->redirectToRoute('app_dashboard_admin'); 
    }

}
