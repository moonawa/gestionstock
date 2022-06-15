<?php

namespace App\Controller;
use App\Form\UserType;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_index')]
    public function index(): Response
    {
        // return $this->render('user/index.html.twig', [
        //     'controller_name' => 'UserController',
        // ]);

        $em = $this->getDoctrine()->getManager();
        $u = new User();
        $form = $this->createForm(UserType::class, $u, array('action' => $this->generateUrl('registration')));
        $data['form'] = $form->createView();
        $data['users'] = $em->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', $data);
    }

//     #[Route('/User/add', name: 'user_add', methods: 'GET","POST')]
//     public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
// {
//         $user = new User();
//         $form = $this->createForm(UserType::class, $user);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//                 $entityManager = $this->getDoctrine()->getManager();
//                 //encodage du mot de passe
//                 $user->setPassword(
//                 $passwordEncoder->encodePassword($user, $user->getPassword()));
//                // Set their role
//                 $user->setRoles(['ROLE_USER']);
//                 $entityManager->persist($user);
//                 $entityManager->flush();

//                 return $this->redirectToRoute('user_index');
//         }

//         return $this->render('user/index.html.twig', [
//         'user' => $user,
//         'form' => $form->createView(),
//         ]);
// }
#[Route('/registration', name: 'registration')]
    public function new(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            // Set their role
            $user->setRoles(['ROLE_USER']);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
    }
    return $this->render('registration/index.html.twig', [
        'form' => $form->createView(),
    ]);
    }

}
