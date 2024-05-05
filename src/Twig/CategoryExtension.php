<?php

// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\TwigFunction;
use App\Entity\Categorie;
use App\Entity\Souscategorie;
use Twig\Extension\AbstractExtension;
use Doctrine\ORM\EntityManagerInterface;

class AppExtension extends AbstractExtension
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCategories', [$this, 'getCategories']),
            new TwigFunction('getSubcategories', [$this, 'getSubcategories']),
        ];
    }

    public function getCategories(): array
    {
        return $this->entityManager->getRepository(Categorie::class)->findAll();
    }

public function getSubcategories(Categorie $category): array
{
    // Get the repository for Souscategorie entity
    $repository = $this->entityManager->getRepository(Souscategorie::class);

    // Fetch subcategories for the selected category
    $subcategories = $repository->findBy(['categorieid' => $category]);

    // Create an array to store subcategories with category IDs
    $subcategoriesWithCategoryIds = [];

    // Iterate through each subcategory
    foreach ($subcategories as $subcategory) {
        // Get the category ID for the current subcategory
        $categoryId = $subcategory->getCategorieid()->getId();

        // Add subcategory and category ID to the result array
        $subcategoriesWithCategoryIds[] = [
            'subcategory' => $subcategory->getNom(),
            'subcategory_id' => $subcategory->getId(),

            'categoryId' => $categoryId
        ];
    }

    return $subcategoriesWithCategoryIds;
}


}
