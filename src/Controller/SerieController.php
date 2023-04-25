<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    #[Route('/admin/series', name: 'app_admin_series')]
    public function adminIndex(): Response
    {
        return $this->render('admin/serie/index.html.twig', [
            'controller_name' => 'SerieController',
        ]);
    }

    #[Route('/admin/series/create', name: 'app_admin_series_create')]
    public function create(): Response
    {
        return $this->render('admin/serie/index.html.twig', [
            'controller_name' => 'SerieController',
        ]);
    }
}
