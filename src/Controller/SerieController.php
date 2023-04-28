<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SerieController extends AbstractController
{
    private $entityManager;
    private $repo;

    public function __construct(EntityManagerInterface $em, SerieRepository $repo)
    {
        $this->entityManager = $em;
        $this->repo = $repo;
    }
    
    #[Route('/admin/series', name: 'app_admin_series')]
    public function adminIndex(): Response
    {
        $series = $this->repo->findAll();

        return $this->render('admin/serie/index.html.twig', [
            'series' => $series,
        ]);
    }

    #[Route('/admin/serie/create', name: 'app_admin_serie_create')]
    public function create(Request $request): Response
    {
        $serie = new Serie();

        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $serie->setCreatedAt(new \DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));

            $this->entityManager->persist($serie);
            $this->entityManager->flush();


            return $this->redirectToRoute('app_admin_series');
        }

        return $this->render('admin/serie/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/serie/update/{serie}', name: 'app_admin_serie_update')]
    public function update(Request $request, Serie $serie): Response
    {
        $serie = $this->repo->find($serie);

        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($serie);
            $this->entityManager->flush();


            return $this->redirectToRoute('app_admin_series');
        }

        return $this->render('admin/serie/update.html.twig', [
            'form' => $form->createView(),
            'serie' => $serie
        ]);
    }

    #[Route('/serie/{serie}', name: 'app_series')]
    public function show(Serie $serie): Response
    {
        
        return $this->render('client/serie/show.html.twig', [
            'serie' => $serie,
        ]);
    }
}
