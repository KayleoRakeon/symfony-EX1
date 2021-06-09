<?php

namespace App\Controller;
use App\Entity\Modele;
use App\Form\ModeleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModeleController extends AbstractController
{
    /**
     * @Route("/modele", name="modele")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $modele = new Modele();
        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($modele);
            $em->flush();

            $this->addFlash('success', 'Modèle ajouté');
        }

        $modele = $em->getRepository(Modele::class)->findAll();

        return $this->render('modele/index.html.twig', [
            'modele' => $modele,
            'ajout' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modele/{id}", name="un_modele")
     */
    public function modele(Modele $modele = null, Request $request){
        if($modele == null){
            $this->addFlash('danger', 'Modèle non trouvé');
            return $this->redirectToRoute('modele');
        }

        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($modele);
            $em->flush();

            $this->addFlash('success', 'Modèle modifié');
        }

        return $this->render('modele/modele.html.twig', [
            'modele' => $modele,
            'edit' => $form->createView(),
        ]);
    }
}



