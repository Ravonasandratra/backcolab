<?php

namespace App\Controller\API\public;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class UsersController extends AbstractController
{
    #[Route('/api/public/user/{id}', name: 'api_users_show', methods: ['GET'])]
    public function index(User $user): JsonResponse
    {
        return $this->json($user, 200, [], [
            "groups" => ["user.show"]
        ]);
    }

    #[Route('/api/public/user', name: 'api_users_listing', methods: ['GET'])]
    public function listingUser(UserRepository $userRepository, Request $request): JsonResponse
    {
        $domain = $request->query->get("domain");
        $category = $request->query->get("category");
        $subCategory = $request->query->get("subCategory");
        $page = $request->query->get("page");
        $limit = 10;
        $page = 1;

        if($page && $page < 1) {
            $page = 1;
        };
        if($subCategory) {
            $domain = $category = null;
        }

        if(!$subCategory && $category) {
            $domain = null;
        };

        $users = $userRepository->listingUserWhithFilter(domain: $domain, category: $category, subCategory: $subCategory, page: $page, lim: 10);

        return $this->json($users, 200, [], [
            "groups" => ["user.listing"],
            "limit" => $limit,
            "currentpage" => $request->getUri()
        ]);
    }

    #[Route('/api/public/user', name: 'api_users_post', methods: ['POST'])]
    public function postUser(
        #[MapRequestPayload(
            "json",
            [
                "groups" => "user.postable"
            ]
        )]
        User $user
    ): JsonResponse
    {
        return $this->json($user);
    }
}