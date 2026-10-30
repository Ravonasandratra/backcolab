<?php

namespace App\Controller\API\public;

use App\Entity\Formations;
use App\Security\Voter\FormationsVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/public/formations')]
#[IsGranted("IS_AUTHENTICATED_FULLY")]
final class FormationsController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/new', name: 'api_user_formation_new', methods: ['POST'])]
    public function new(
        #[MapRequestPayload("json", ["groups" => "formation.post"])]
        Formations $formation
    ): JsonResponse
    {
        $formation->setUser($this->getUser());
        $this->entityManager->persist($formation);
        $this->entityManager->flush();
        return $this->json(["success" => true], 200);
    }

    #[Route('/{id}', name: 'api_user_formation_show', methods: ['GET'])]
    #[IsGranted(FormationsVoter::VIEW, subject: "formation")]
    public function show(Formations $formation): JsonResponse
    {

        return $this->json($formation, 200, [], ["groups" => "user.show"]);
    }

    #[Route('/{id}/edit', name: 'api_user_formation_edit', methods: ['POST'])]
    #[IsGranted(FormationsVoter::EDIT, subject: "oldFormation")]
    public function edit(
        Request $request, 
        #[MapRequestPayload(
            "json", ["groups" => "formation.post"]
        )]
        Formations $formation,
        Formations $oldFormation,
        SerializerInterface $serializer
        ): JsonResponse
    {
        $serializer->deserialize($request->getContent(), Formations::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $oldFormation]);

        $this->entityManager->persist($oldFormation);
        $this->entityManager->flush();
        return $this->json(["success" => true], 200);
    }

    #[Route('/{id}', name: 'api_user_formation_delete', methods: ['POST'])]
    #[IsGranted(FormationsVoter::DELETE, subject: "formation")]
    public function delete(Formations $formation): JsonResponse
    {
        $this->entityManager->remove($formation);
        $this->entityManager->flush();

        return $this->json(["success" => true], 200);
    }
}
