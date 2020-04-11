<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use Symfony\Component\HttpFoundation\Response;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        
        return $this->render('admin/account/login.html.twig', [
            'hasError' => $error !== null
        ]);
    }
    
    /**
     * permet de se deconnecter
     * 
     * @Route("/admin/logout", name="admin_account_logout")
     * 
     * @return void
     */
    public function logout(){
        //.....
    }
    
}






