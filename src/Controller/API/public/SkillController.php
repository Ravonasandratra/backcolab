<?php

namespace App\Controller\API\public;

use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/public/skill')]
#[IsGranted("IS_AUTHENTICATED_FULLY")]
final class SkillController extends AbstractController
{
    
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/new', name: 'api_user_skill_new', methods: ['POST'])]
    public function new(Request $request, 
    ValidatorInterface $validator): JsonResponse
    {
        $user = $this->getUser();
        $payload = json_decode($request->getContent(), true) ?? [];

        // Récupération de 'skills' (peut être une chaîne JSON encodée ou un tableau)
        $rawSkills = $payload['skills'] ?? [];
        if (is_string($rawSkills)) {
            $skillsList = json_decode($rawSkills, true) ?? [];
        } else {
            $skillsList = $rawSkills;
        }

        if (empty($skillsList)) {
            return $this->json([
                'violations' => [
                    ['propertyPath' => 'skills', 'title' => 'Aucune compétence fournie.']
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        $addedSkills = [];
        foreach ($skillsList as $item) {
            $skill = new Skill();
            $skill->setName($item["name"]);
            $skill->setLevel($item["level"]);
            $skill->setUser($user);

            $errors = $validator->validate($skill);
            if (count($errors) > 0) {
                $violations = [];
                foreach ($errors as $error) {
                    $violations[] = [
                        'propertyPath' => $error->getPropertyPath(),
                        'title' => $error->getMessage(),
                    ];
                }
                return $this->json(['violations' => $violations], Response::HTTP_BAD_REQUEST);
            }

            $this->entityManager->persist($skill);
            $addedSkills[] = $skill;
        }

        $this->entityManager->flush();

        return $this->json([
            'success' => true,
        ], 200);
    }

    #[Route('/{id}', name: 'api_user_skill_delete', methods: ['POST'])]
    public function delete(Skill $skill): JsonResponse
    {
        $this->entityManager->remove($skill);
        $this->entityManager->flush();

        return $this->json(["success" => true]);
    }
}
