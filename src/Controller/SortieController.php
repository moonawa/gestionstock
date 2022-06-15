<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\Produit;

use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/Sortie/liste", name="sortie_liste")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $s = new Sortie();
        $form = $this->createForm(SortieType::class, $s, array('action' => $this->generateUrl('sortie_add')));
        $data['form'] = $form->createView();
        $data['sorties'] = $em->getRepository(Sortie::class)->findAll();

        return $this->render('sortie/liste.html.twig', $data);
    }

    /**
     * @Route("/Sortie/get/{id}", name="sortie_get ")
     */
    public function getSortie($id)
    {
        return $this->render('sortie/liste.html.twig');
    }
    /**
     * @Route("/Sortie/add", name="sortie_add")
     */
    public function add(Request $request)
    {
        $s = new Sortie(); 
        $form = $this->createForm(SortieType::class, $s);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $s = $form->getData();
            $qsortie = $s->getQtS();
            $em = $this->getDoctrine()->getManager();
            $p = $em->getRepository(Produit::class)->find($s->getProduit()->getId());
            if($p->getQtStock() < $s->getQtS()){
                $s = new Sortie();
                $form = $this->createForm(SortieType::class, $s, array('action' => $this->generateUrl('sortie_add')));        
                $data['form'] = $form->createView();
                $data['sorties'] = $em->getRepository(Sortie::class)->findAll();
                $data['error_message'] = 'Le stock disponible est inférieur à '.$qsortie ;
                return $this->render('sortie/liste.html.twig', $data);
            }else{
                $em->persist($s);
                $em->flush();
                //Mise à jour
                $stock = $p->getQtStock() - $s->getQtS();
                $p->setQtStock($stock);
                $em->flush(); 
                return $this->redirectToRoute('sortie_liste');
            }
              
     
        }
        return $this->redirectToRoute('sortie_liste');
    }
}
