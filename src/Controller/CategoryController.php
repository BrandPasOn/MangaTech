<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/admin/categories', name: 'app_admin_categories')]
    public function AdminIndex(): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
