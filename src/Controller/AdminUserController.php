<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AccountType;
use Symfony\Component\HttpFoundation\Response;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users_index")
     */
    public function index(UserRepository $repo)
    {
        $users = $repo->findAll();
        
        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }
    
    /**
     * permet de modifier les informations d'un utilisateur
     * 
     * @Route("/admin/users/{id}/edit", name="admin_users_edit")
     */
    public function edit(User $user, Request $request){
        
        $form = $this->createForm(AccountType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($user);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "L'utilisateur a bien été modifié"
            );
            
            return $this->redirectToRoute('admin_users_index'); 
        }
        
        return $this->render('admin/user/edit.html.twig',[
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
    
    /**
     * permet de supprimer un utilisateur
     * 
     * @Route("/admin/users/{id}/delete", name="admin_users_delete")
     * 
     * @return Response
     */
    public function delete(User $user, Request $request){
        $manager = $this->getDoctrine()->getManager();
        
        //verifier si le user a deja une commande
        
        if(count($user->getAchats()) > 0 || count($user->getAnnonces()) > 0){
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer l'annonce <strong>{$user->getFullName()}</strong>
                    car elle est déja des commandes ou des annonces en ligne"
            );
        }else{
            $manager->remove($user);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "L'utilisateur <strong>{$user->getFullName()}</strong> a bien été supprimé");
        }
        return $this->redirectToRoute('admin_users_index');
    }
}








