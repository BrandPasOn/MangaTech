<?php

namespace App\Controller;

use App\Entity\Borrowing;
use DateTimeZone;
use App\Entity\Manga;
use App\Entity\Serie;
use App\Form\BorrowingType;
use App\Form\MangaType;
use App\Repository\BorrowingRepository;
use App\Repository\MangaRepository;
use App\Services\isGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MangaController extends AbstractController
{
    private $entityManager;
    private $repo;
    private $borrowingRepo;

    public function __construct(EntityManagerInterface $em, MangaRepository $repo, BorrowingRepository $borrowingRepo)
    {
        $this->entityManager = $em;
        $this->repo = $repo;
        $this->borrowingRepo = $borrowingRepo;
    }
    
    #[Route('/admin/mangas', name: 'app_admin_manga')]
    public function adminList(): Response
    {
        $mangas = $this->repo->findAllOrderBy('created_at', 'ASC');


        return $this->render('admin/manga/list.html.twig', [
            'mangas' => $mangas,
        ]);
    }
    
    #[Route('/admin/serie/{serie}/mangas', name: 'app_admin_serie_manga')]
    public function adminIndex(Serie $serie): Response
    {
        $mangas = $this->repo->findBySerie($serie);


        return $this->render('admin/manga/index.html.twig', [
            'mangas' => $mangas,
            'serie' => $serie
        ]);
    }


    #[Route('/admin/serie/{serie}/manga/create', name: 'app_admin_serie_manga_create')]
    public function create(Request $request, Serie $serie): Response
    {
        $manga = new Manga();

        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('image')['file']->getData();
            $extension = $file->guessExtension();
            if (!$extension) {
                // extension cannot be guessed
                $extension = 'bin';
            }

            $imageName = str_replace(' ', '-', strtolower("{$serie->getName()}-tome-{$request->get('manga')['volume_number']}"));

            $file->move(
                $this->getParameter('images_directory'),
                $imageName . "." . $extension
            );

            $manga->getImage()->setName($imageName);
            $manga->getImage()->setUrl("/assets/images/" . strtolower($imageName) . "." . $extension);
            
            $manga->setCreatedAt(new \DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
            $manga->setSerie($serie);
            
            $this->entityManager->persist($manga);
            $this->entityManager->flush();
            
            return $this->redirectToRoute('app_admin_serie_manga', ['serie' => $serie->getId()]);
        }

        return $this->render('admin/manga/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/serie/{serie}/manga/update/{manga}', name: 'app_admin_serie_manga_update')]
    public function update(Request $request, Serie $serie, Manga $manga): Response
    {
        $manga = $this->repo->find($manga);

        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('image')['file']->getData();
            if($file){

                $extension = $file->guessExtension();
                if (!$extension) {
                    // extension cannot be guessed
                    $extension = 'bin';
                }
                
                $imageName = str_replace(' ', '-', strtolower("{$serie->getName()}-tome-{$request->get('manga')['volume_number']}"));
                
                $file->move(
                    $this->getParameter('images_directory'),
                    $imageName . "." . $extension
                );
                
                $manga->getImage()->setName($imageName);
                $manga->getImage()->setUrl("/assets/images/" . strtolower($imageName) . "." . $extension);
            }
            
            $manga->setSerie($serie);
            
            $this->entityManager->persist($manga);
            $this->entityManager->flush();
            
            return $this->redirectToRoute('app_admin_serie_manga', ['serie' => $serie->getId()]);
        }

        return $this->render('admin/manga/update.html.twig', [
            'form' => $form->createView(),
            'manga' => $manga
        ]);
    }

    #[Route('/manga/{manga}', name: 'app_manga')]
    public function show(Manga $manga, Request $request): Response
    {
        $borrowing = new Borrowing();
        $form = $this->createForm(BorrowingType::class, $borrowing);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $verificator = new IsGranted();
            $isGranted = $verificator->verifySubscription($this->getUser(), $manga, $this->borrowingRepo);

            if ($isGranted) {

                $borrowing->setBorrowingDate(new \DateTimeImmutable('now'), new DateTimeZone('Europe/Paris'));
                $borrowing->setIsReturned(false);
                $borrowing->setUser($this->getUser());
                $borrowing->setManga($manga);

                $manga->getStock()->setQuantity(($manga->getStock()->getQuantity()) - 1);

                $this->entityManager->persist($borrowing);
                $this->entityManager->persist($manga);
                $this->entityManager->flush();

                $this->addFlash('success', 'Votre emprunt à bien été enregistrer');

                return $this->redirectToRoute('app_manga', ['manga' => $manga->getId()]);
            } else {
                $this->addFlash('error', 'Vous ne pouvez pas emprunter de manga');

                return $this->redirectToRoute('app_manga', ['manga' => $manga->getId()]);
            }
        }

        return $this->render('client/manga/show.html.twig', [
            'manga' => $manga,
            'form' => $form->createView()
        ]);
    }
}
