<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UpdateAdminType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home_page');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    //UPDATE USER
    #[Route('/update/{id}', name: 'app_home_page_registerUpdate')] 
    public function update_form($id, Request $request, EntityManagerInterface $entityManager): Response 
    {
        $crud = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(RegistrationFormType::class, $crud); 
        $form->handleRequest($request);
        if  ( $form->isSubmitted() && $form->isValid()){ 
            $entityManager->persist($crud);
            $entityManager->flush(); 

            // $this->addFlash('notice', 'Modification réussie !');

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

        // $this->addFlash('notice', 'Suppression réussie !');

        return $this->redirectToRoute('app_home_page'); 
    }

    
}
