<?php

namespace App\Controller\API\public;

use App\Entity\User;
use App\Repository\UserRepository;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UsersController extends AbstractController
{
    public function __construct(private readonly CacheManager $cache)
    {
    }

    #[Route('/api/public/user/{id}', name: 'api_users_show', methods: ['GET'])]
    public function index(User $user): JsonResponse
    {
        $user->getAvatar() ? $user->setAvatar($this->cache->getBrowserPath("/media/avatar/".$user->getAvatar(), "avatar")) : null;
        return $this->json($user, 200, [], [
            "groups" => ["user.show"]
        ]);
    }

    #[IsGranted("IS_AUTHENTICATED")]
    #[Route('/api/public/me', name: 'api_me_show', methods: ['GET'])]
    public function mete(
        #[CurrentUser()]
        User $user
        ): JsonResponse
    {
        $user->getAvatar() ? $user->setAvatar($this->cache->getBrowserPath("/media/avatar/".$user->getAvatar(), "avatar")) : null;
        return $this->json($user, 200, [], [
            "groups" => ["user.profil"]
        ]);
    }


    #[Route('/api/public/user', name: 'api_users_listing', methods: ['GET'])]
    public function listingUser(UserRepository $userRepository, Request $request): JsonResponse
    {
        $domain = $request->query->get("domain");
        $category = $request->query->get("category");
        $subCategory = $request->query->get("subCategory");
        $page = $request->query->get("page") ?? 1;
        $limit = 10;

        if($page < 1) {
            $page = 1;
        };
        if($subCategory) {
            $domain = $category = null;
        }

        if(!$subCategory && $category) {
            $domain = null;
        };

        $users = $userRepository->listingUserWhithFilter(domain: $domain, category: $category, subCategory: $subCategory, page: $page, lim: $limit);

        return $this->json($users, 200, [], [
            "groups" => ["user.listing"],
            "limit" => $limit,
            "currentpage" => (int)$page
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