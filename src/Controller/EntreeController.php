<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Entity\Produit;
use App\Form\EntreeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EntreeController extends AbstractController
{
    /**
     * @Route("/Entree/liste", name="entree_liste")
    */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $e = new Entree();
        $form = $this->createForm(EntreeType::class, $e, array('action' => $this->generateUrl('entree_add')));
        $data['form'] = $form->createView();
        $data['entrees'] = $em->getRepository(Entree::class)->findAll();

        return $this->render('entree/liste.html.twig', $data);
    }

    /**
     * @Route("/Entree/get/{id}", name="entree_get ")
     */
    public function getEntree($id)
    {
        return $this->render('entree/liste.html.twig');
    }

    /**
     * @Route("/Entree/add", name="entree_add")
     */
    public function add(Request $request)
    {
        $e = new Entree(); 
        $form = $this->createForm(EntreeType::class, $e);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $e = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($e);
            $em->flush();
            //Mise à jour
            $p = $em->getRepository(Produit::class)->find($e->getProduit()->getId());
            $stock = $p->getQtStock() + $e->getQtE();
            $p->setQtStock($stock);
            $em->flush();
        }
        return $this->redirectToRoute('entree_liste');
    }
}
