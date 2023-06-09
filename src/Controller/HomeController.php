<?php

namespace App\Controller;

use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;
    private $repo;

    public function __construct(EntityManagerInterface $em, SerieRepository $repo)
    {
        $this->entityManager = $em;
        $this->repo = $repo;
    }
    
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $series = $this->repo->findAll();

        return $this->render('home/index.html.twig', [
            'series' => $series,
        ]);
    }
}
