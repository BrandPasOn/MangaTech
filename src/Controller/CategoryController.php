<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    private $entityManager;
    private $repo;

    public function __construct(EntityManagerInterface $em, CategoryRepository $repo)
    {
        $this->entityManager = $em;
        $this->repo = $repo;
    }


    #[Route('/admin/categories', name: 'app_admin_categories')]
    public function AdminIndex(): Response
    {
        $categories = $this->repo->findAll();

        return $this->render('admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories'      => $categories  
        ]);
    }

    #[Route('/admin/category/create', name: 'app_admin_category_create')]
    public function create(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($category);
            $this->entityManager->flush();


            return $this->redirectToRoute('app_admin_categories');
        }

        return $this->render('admin/category/create.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/category/update/{category}', name: 'app_admin_category_update')]
    public function update(Request $request, Category $category): Response
    {
        $category = $this->repo->find($category);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($category);
            $this->entityManager->flush();


            return $this->redirectToRoute('app_admin_categories');
        }

        return $this->render('admin/category/update.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }
}
