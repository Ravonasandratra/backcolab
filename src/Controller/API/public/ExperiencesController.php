<?php

namespace App\Controller\API\public;

use App\Entity\Experiences;
use App\Security\Voter\ExperiencesVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/public/experiences')]
#[IsGranted("IS_AUTHENTICATED_FULLY")]
final class ExperiencesController extends AbstractController
{

    public function __construct(public readonly EntityManagerInterface $em)
    {
    }

    #[Route('/new', name: 'api_user_experience_new', methods: ['GET', 'POST'])]
    public function new(
        #[MapRequestPayload(
            "json",["groups" => "experience.post"]
        )]
        Experiences $experience
    ): JsonResponse
    {
        $experience->setUser($this->getUser());
        $this->em->persist($experience);
        $this->em->flush();
        return $this->json(["success" => true], 200);
    }

    #[Route('/{id}', name: 'api_user_experience_show', methods: ['GET'])]
    #[IsGranted(ExperiencesVoter::VIEW, subject: "experience")]
    public function show(Experiences $experience): JsonResponse
    {
        return $this->json($experience, 200, [], ["groups" => "user.show"]);
    }

    #[Route('/{id}/edit', name: 'api_user_experience_edit', methods: ['POST'])]
    #[IsGranted(ExperiencesVoter::VIEW, subject: "oldExperience")]
    public function edit(
        Request $request, 
        #[MapRequestPayload(
            "json",["groups" => "experience.post"]
        )]
        Experiences $experience, 
        Experiences $oldExperience,
        SerializerInterface $serializer
        ): JsonResponse
    {
        
        $serializer->deserialize($request->getContent(), Experiences::class, "json", [
            AbstractNormalizer::OBJECT_TO_POPULATE => $oldExperience
        ]);

        $this->em->persist($oldExperience);
        $this->em->flush();

        return $this->json(["success" => true], 200);
    }

    #[Route('/{id}', name: 'api_user_experience_delete', methods: ['POST'])]
    public function delete(Experiences $experience): JsonResponse
    {
        $this->em->remove($experience);
        $this->em->flush();

        return $this->json(["success" => true]);
    }
}
