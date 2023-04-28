<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Form\SubscriptionType;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    private $entityManager;
    private $repo;
    private $userRepo;

    public function __construct(EntityManagerInterface $em, SubscriptionRepository $repo, UserRepository $userRepo)
    {
        $this->entityManager = $em;
        $this->repo = $repo;
        $this->userRepo = $userRepo;
    }
    
    #[Route('/admin/subscriptions', name: 'app_admin_subscriptions')]
    public function adminIndex(): Response
    {
        $subs = $this->repo->findAll();

        return $this->render('admin/subscription/index.html.twig', [
            'subs' => $subs,
        ]);
    }


    #[Route('/admin/subscription/create', name: 'app_admin_subscription_create')]
    public function create(Request $request): Response
    {
        $sub = new Subscription();

        $form = $this->createForm(SubscriptionType::class, $sub);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            $this->entityManager->persist($sub);
            $this->entityManager->flush();


            return $this->redirectToRoute('app_admin_subscriptions');
        }

        return $this->render('admin/subscription/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/subscription/update/{sub}', name: 'app_admin_subscription_update')]
    public function update(Request $request, Subscription $sub): Response
    {
        $sub = $this->repo->find($sub);

        $form = $this->createForm(SubscriptionType::class, $sub);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            $this->entityManager->persist($sub);
            $this->entityManager->flush();


            return $this->redirectToRoute('app_admin_subscriptions');
        }

        return $this->render('admin/subscription/update.html.twig', [
            'form' => $form->createView(),
            'sub' => $sub
        ]);
    }


    #[Route('/subscriptions', name: 'app_subscriptions')]
    public function index(): Response
    {
        $subs = $this->repo->findAll();

        return $this->render('client/subscription/index.html.twig', [
            'subs' => $subs,
        ]);
    }


    #[Route('/user/subscription', name: 'app_user_subscription')]
    public function subscribe(Request $request): Response
    {
        $user_id = $request->request->get('user_id');
        $sub_id = $request->request->get('sub_id');
        
        $user = $this->userRepo->find($user_id);
        $sub = $this->repo->find($sub_id);

        $user->setSubscription($sub);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->addFlash('subscribSuccess', 'Vous êtes maintenant abonné');

        return $this->redirectToRoute('app_home');
    }
}
