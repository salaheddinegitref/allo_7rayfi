<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\StatsService;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(EntityManagerInterface $manager, StatsService $statsService)
    {
        $stats = $statsService->getStats();
        
        $bestAnnonces = $statsService->getBestAnnonces();
       
        $badAnnonces = $statsService->getBadAnnonces();
        
        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => $stats,
            'bestAnnonces' => $bestAnnonces,
            'badAnnonces' => $badAnnonces
        ]);
    }
}
