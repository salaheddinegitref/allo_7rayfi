<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;
use App\Form\AchatType;
use App\Entity\Achat;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AchatController extends AbstractController
{
    /**
     * @Route("/annonces/{slug}/achat", name="achat_create")
     * 
     * @IsGranted("ROLE_USER")
     */
    public function achat(Annonce $annonce, Request $request)
    {
        $achat = new Achat();
        
        $form = $this->createForm(AchatType::class, $achat);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $user = $this->getUser();
          
            $achat->setBuyer($user)
                  ->setAnnonce($annonce);           
            
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($achat);
            $manager->flush();
            
            return $this->redirectToRoute('achat_show', [
                'id' => $achat->getId(),
                'withAlert' => true
            ]);
        }
        
        return $this->render('achat/achat.html.twig', [
            'annonce' => $annonce,
            'form'   => $form->createView()
        ]);
    }
    
    /**
     * permet d'afficher la page un achat
     * 
     * @Route("/achat/{id}", name="achat_show")
     * 
     * @return Response
     */
    public function show(Achat $achat){
        
        return $this->render('achat/show.html.twig', [
            'achat' => $achat
        ]);
    }
}





