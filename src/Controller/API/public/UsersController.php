<?php

namespace App\Controller\API\public;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UsersController extends AbstractController
{
    #[Route('/api/public/user', name: 'api_users')]
    public function index(): JsonResponse
    {
        return $this->json(["users" => [
            "name" => "Ravonasandratra",
            "firstName" => "Betay",
        ]]);
    }
}
