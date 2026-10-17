<?php

namespace App\Controller\API\public;

use App\DTO\Users\PasswordUserDTO;
use App\DTO\Users\ProfilUserDTO;
use App\Entity\Information;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("IS_AUTHENTICATED_FULLY")]
class UsersChangeController extends AbstractController {

    public function __construct(
        private readonly CacheManager $cache, 
        private readonly EntityManagerInterface $em,
        )
    {
    }

    #[Route('/api/public/me', name: 'api_me_show', methods: ['GET'])]
    public function me(
        #[CurrentUser()]
        User $user
        ): JsonResponse
    {
        $user->getAvatar() ? $user->setAvatar($this->cache->getBrowserPath("/media/avatar/".$user->getAvatar(), "avatar")) : null;
        return $this->json($user, 200, [], [
            "groups" => ["user.profil"]
        ]);
    }

    #[Route('/api/public/update/user/{id}/profil', name: 'api_user_update_profil', methods: ["POST"], requirements: ["id" => "\d+"])]
    public function updateProfil(
        #[MapRequestPayload()]
        ProfilUserDTO $profil,
        Request $request,
    ): JsonResponse {
        
    /** @var User $currentUser */
        $currentUser = $this->getUser();
        if($currentUser->getId() != (int)$request->attributes->get("id")){
            return $this->json(["message" => "Vous ne pouvez modifier cette profil"], 401);
        }

        $currentUser->setFirstname($profil->firstname);
        $currentUser->setLastname($profil->lastname);
        $currentUser->setDescription($profil->description);
        
        $this->em->persist($currentUser);
        $this->em->flush();

        return $this->json(["success" => true], 200);
    }


    #[Route('/api/public/update/user/{id}/password', name: 'api_user_update_password', methods: ["POST"], requirements: ["id" => "\d+"])]
    public function updatePassword(
        #[MapRequestPayload()]
        PasswordUserDTO $password,
        Request $request,
        UserPasswordHasherInterface $hasher
    ): JsonResponse {
        
    /** @var User $currentUser */
        $currentUser = $this->getUser();
        if($currentUser->getId() != (int)$request->attributes->get("id")){
            return $this->json(["message" => "Vous ne pouvez modifier cette profil"], 401);
        }

        $currentUser->setPassword($hasher->hashPassword($currentUser, $password->newPassword));
        
        $this->em->persist($currentUser);
        $this->em->flush();

        return $this->json($currentUser, 200, [], [
            "groups" => ["user.profil"]
        ]);
    }

    #[Route('/api/public/post/user/{id}/information', name: 'api_user_information', methods: ["POST"], requirements: ["id" => "\d+"])]
    public function newIfonrmation(
        #[MapRequestPayload(
            "json", ["groups" => "information.post"]
        )]
        Information $information,
        Request $request,
    ): JsonResponse {
        
    /** @var User $currentUser */
        $currentUser = $this->getUser();
        if($currentUser->getId() != (int)$request->attributes->get("id")){
            return $this->json(["message" => "Vous ne pouvez modifier cette profil"], 401);
        }

        $information->setUser($currentUser);
        $information->setAdress("");
        
        $this->em->persist($information);
        $this->em->flush();

        return $this->json(["success" => true], 200);
    }
}