<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TechnicalTestController extends AbstractController
{
    /**
     * @Route("/view/{user}", name="app_technical_test_view")
     */
    public function view($user): JsonResponse
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($user);
        $this->getDoctrine()->getManager();
        $user->setLastActionAt(new \DateTimeImmutable());
        $user->setLastActionBy($this->getUser());
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->json([
            'message' => 'Welcome to user view !',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit/{user}", name="app_technical_test_add")
     */
    public function edit(Request $request, $user): JsonResponse
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($user);
        $user->setName($request->get('name'));
        $user->setLastActionAt(new \DateTimeImmutable());
        $user->setLastActionBy($this->getUser());
        return $this->json([
            'message' => 'User is updated !',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/add", name="app_technical_test_add")
     */
    public function add(Request $request): JsonResponse
    {
        $user = new User();
        $user->setName($request->get('name'));
        $user->setLastActionAt(new \DateTimeImmutable());
        $user->setLastActionBy($this->getUser());
        return $this->json([
            'message' => 'User is added !',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/index", name="app_technical_test_index")
     */
    public function index(): JsonResponse
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->json([
            'message' => 'Welcome to users\'s list',
            'user' => $users,
        ]);
    }

    /**
     * @Route("/count", name="app_technical_test_count")
     */
    public function count(): JsonResponse
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->json([
            'message' => 'Welcome to users\'s count',
            'count_user' => count($users),
        ]);
    }

    /**
     * @Route("/offers/{user}", name="app_technical_test_offers")
     */
    public function offers($user): JsonResponse
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($user);
        foreach ($user->getOffers()->getValues() as $offer) {
            $offers[] = $offer->getTitle();
        }
        return $this->json([
            'message' => 'Welcome to users\'s offers',
            'offers' => $offers ?? [],
        ]);
    }
}
