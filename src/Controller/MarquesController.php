<?php

namespace App\Controller;
use App\Entity\Marques;
use App\Form\MarquesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarquesController extends AbstractController
{
    /**
     * @Route("/marques", name="marques")
     */
    public function marques(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        
        $marques = new Marques();
        $form = $this->createForm(MarquesType::class, $marques);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($marques);
            $em->flush();

            $this->addFlash('success', 'Marque ajoutée');
        }

        $marques = $em->getRepository(Marques::class)->findAll();

        return $this->render('marques/index.html.twig', [
            'marques' => $marques,
            'ajout' => $form->createView(),
        ]);
    }

    /**
     * @Route("/marques/{id}", name="une_marque")
     */
    public function marque(Marques $marques = null, Request $request){
        if($marques == null){
            $this->addFlash('danger', 'Marque non trouvée');
            return $this->redirectToRoute('marques');
        }

        $form = $this->createForm(MarquesType::class, $marques);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($marques);
            $em->flush();

            $this->addFlash('success', 'Marque modifiée');
        }

        return $this->render('marques/marques.html.twig', [
            'marques' => $marques,
            'edit' => $form->createView(),
        ]);
    }

}
