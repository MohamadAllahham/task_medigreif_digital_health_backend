<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\UserService;

class UserController extends AbstractController
{
    #[Route('/api/user/{id}', name: 'get_user_info', methods: ['GET'])]
    public function getUserInfo(string $id, UserService $userService): JsonResponse
    {
        return $userService->handleGetUserInfo($id);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, UserService $userService): JsonResponse
    {
        return $userService->handleLogin($request);
    }
}
