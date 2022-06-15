<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie/liste', name: 'categorie_liste')]
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $c = new Categorie();
        $form = $this->createForm(CategorieType::class, $c, array('action' => $this->generateUrl('categorie_add')));
        $data['form'] = $form->createView();
        $data['categories'] = $em->getRepository(Categorie::class)->findAll();

        // return $this->render('categorie/index.html.twig', [
        //     'controller_name' => 'CategorieController',
        // ]);
        return $this->render('categorie/index.html.twig', $data);

    }

    #[Route('/categorie/get/{id}', name: 'categorie_get')]
    public function getCategorie($id)
    {
        return $this->render('categorie/liste.html.twig');
    }

    #[Route('/categorie/add', name: 'categorie_add')]
    public function add(Request $request)
    {
        $c = new Categorie(); 
        $form = $this->createForm(CategorieType::class, $c);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $c = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute('categorie_liste');
        }
        return $this->redirectToRoute('categorie_liste');
    }
}
