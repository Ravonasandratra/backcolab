<?php

namespace App\Controller\API\public;

use App\Entity\Information;
use App\Entity\User;
use App\Security\Voter\InformationVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/public/information')]
#[IsGranted("IS_AUTHENTICATED_FULLY")]
final class InformationController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('/new', name: 'api_user_information_new', methods: ["POST"])]
    public function newIfonrmation(
        #[MapRequestPayload(
            "json", ["groups" => "information.post"]
        )]
        Information $information,
    ): JsonResponse {
        
    /** @var User $currentUser */
        $currentUser = $this->getUser();

        $information->setUser($currentUser);
        $information->setAdress("");
        
        $this->em->persist($information);
        $this->em->flush();

        return $this->json(["success" => true], 200);
    }

    #[Route('/{id}', name: 'api_user_information_show', methods: ['GET'])]
    #[IsGranted(InformationVoter::VIEW, subject: "information")]
    public function show(Information $information): JsonResponse
    {
        return $this->json($information, 200, [], [
            "groups" => "user.show"
        ]);
    }

    #[Route('/{id}/edit', name: 'api_user_information_edit', methods: ['POST'])]
    #[IsGranted(InformationVoter::EDIT, subject: "oldInfo")]
    public function edit(
        Request $request, 
        #[MapRequestPayload(
            "json", ["groups" => "information.post"]
        )]
        Information $information, 
        Information $oldInfo,
        SerializerInterface $serializer
        
        ): JsonResponse
    {

        $serializer->deserialize($request->getContent(), Information::class, "json", [
            AbstractNormalizer::OBJECT_TO_POPULATE => $oldInfo
        ]);
        
        $this->em->persist($oldInfo);
        $this->em->flush();

        return $this->json(["success" => true], 200);
    }

    #[Route('/{id}', name: 'api_user_information_delete', methods: ['POST'])]
    #[IsGranted(InformationVoter::DELETE, subject: "information")]
    public function delete(Information $information): JsonResponse
    {
        
        $this->em->remove($information);
        $this->em->flush();

        return $this->json(["message" => "Information supprimé"], 200);
    }
}
