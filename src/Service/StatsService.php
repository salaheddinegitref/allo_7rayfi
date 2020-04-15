<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class StatsService{
    
    private $manager;
    
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }
    
    public function getStats(){
        $users = $this->getUsersCount();
        $annonces = $this->getAnnoncesCount();
        $comments = $this->getCommentsCount();
        $achats = $this->getAchatsCount();
        
        return compact('users', 'annonces', 'comments', 'achats');
    }
    
    public function getBestAnnonces(){
        return $this->manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName
             FROM App\Entity\Comment c
             JOIN c.annonce a
             JOIN a.Author u
             GROUP BY a ORDER BY note DESC'
            )->setMaxResults(5)->getResult();
    }
    
    public function getBadAnnonces(){
        return $this->manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName
             FROM App\Entity\Comment c
             JOIN c.annonce a
             JOIN a.Author u
             GROUP BY a ORDER BY note ASC'
            )->setMaxResults(5)->getResult();
    }
    
    public function getUsersCount(){
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
    }
    
    public function getAnnoncesCount(){
        return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\Annonce a')->getSingleScalarResult();
    }
    
    public function getCommentsCount(){
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();
    }
    
    public function getAchatsCount(){
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Achat b')->getSingleScalarResult();
    }
}