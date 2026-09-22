<?php

namespace App\Controller\API\public;

use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ItemMenuController extends AbstractController {

    #[Route('/api/public/category', name: 'api_category_show', methods: ['GET'])]
    public function getCategory(CategoryRepository $categoryRepository, Request $request): JsonResponse 
    {
        $domain = (int)$request->query->get("domain") ?? 1;
        return $this->json($categoryRepository->findCategoryFromDomaine($domain), 200, [], [
            "groups" => "Category.show"
        ]);
    }

    #[Route('/api/public/subcategory', name: 'api_subcategory_show', methods: ['GET'])]
    public function getSubCategory(SubCategoryRepository $subCategoryRepository, Request $request): JsonResponse 
    {
        $category = (int)$request->query->get("category") ?? 1;
        return $this->json($subCategoryRepository->findSubCategoryFromCategory($category), 200, [], [
            "groups" => "subcategory.show"
        ]);
    }
}