<?php

namespace App\Controller;

use App\Handler\SportHandler;
use App\Handler\UserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', defaults: ['_format' => 'json'])]
class AdminController extends AbstractController
{
    private UserHandler $userHandler;
    private SportHandler $sportHandler;

    public function __construct(UserHandler $userHandler, SportHandler $sportHandler) {
        $this->userHandler = $userHandler;
        $this->sportHandler = $sportHandler;
    }

    #[Route('/users', name: 'app_admin_users_list', methods: ['GET'])]
    public function getAllUsers(): JsonResponse
    {
        return new JsonResponse($this->userHandler->getAllUsers());
    }

    #[Route('/sports', name: 'app_admin_sports_list', methods: ['GET'])]
    public function getAllSports(): JsonResponse
    {
        return new JsonResponse($this->sportHandler->getAllSportsWithCourts());
    }
}
