<?php

namespace App\Controller\Security;

use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SessionController extends AbstractController {
    #[Route("/api/logout", name: "api_user_logout", methods: ["POST"])]
    public function logout(RefreshTokenManagerInterface $refreshToken, Request $request): JsonResponse {

        $paylod = json_decode($request->getContent(), true);

        $token = $paylod["refres_token"] ?? null;

        

        if(!$token) {
            return $this->json(["success" => false], 401, [], [Response::HTTP_BAD_REQUEST]);
        }

        $objectToken = $refreshToken->get($token);

        if(!$objectToken){
            return $this->json(["success" => false], 401, [], [Response::HTTP_BAD_REQUEST]);
        }

        $refreshToken->delete($objectToken);

        return $this->json(["success" => true]);
    }
}