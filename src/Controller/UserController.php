<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $entityManager;
    private $repo;

    public function __construct(EntityManagerInterface $em, UserRepository $repo)
    {
        $this->entityManager = $em;
        $this->repo = $repo;
    }
    
    #[Route('/profil/{user}', name: 'app_profil')]
    public function index(User $user): Response
    {
        return $this->render('client/profil/index.html.twig', [
            'user' => $user,
        ]);
    }
}
