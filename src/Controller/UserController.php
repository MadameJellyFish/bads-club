<?php

namespace App\Controller;

use App\Handler\UserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/api/user', name: 'app_user', format: 'json')]
    public function index(UserHandler $userHandler): JsonResponse
    {
        $user = $userHandler->getUser();
        if ($user === null) {
            return new JsonResponse(['message' => 'User not autheticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['message' => 'User does not have the rights'], JsonResponse::HTTP_FORBIDDEN);
        }

        return new JsonResponse($userHandler->getAllUsers());

        // return $this->render('user/index.html.twig', [
        //     'controller_name' => 'UserController',
        // ]);
    }
}
