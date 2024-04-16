<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    /**
     * Find all categories.
     *
     * @return Categorie[] Returns an array of Categorie objects
     */
    public function findAllCategories(): array
    {
        return $this->findAll();
    }

    /**
     * Find a category by its ID.
     *
     * @param int $id The ID of the category
     * @return Categorie|null The category object or null if not found
     */
    public function findCategoryById(int $id): ?Categorie
    {
        return $this->find($id);
    }

    /**
     * Create or update a category.
     *
     * @param Categorie $category The category object to save
     */
    public function save(Categorie $category): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($category);
        $entityManager->flush();
    }

    /**
     * Delete a category.
     *
     * @param Categorie $category The category object to delete
     */
    public function delete(Categorie $category): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($category);
        $entityManager->flush();
    }

    /**
     * Find categories by name using a LIKE query.
     *
     * @param string $name The name to search for
     * @return Categorie[] Returns an array of Categorie objects matching the search
     */
    public function findCategoriesByName(string $name): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.nom LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find categories sorted by last updated date.
     *
     * @return Categorie[] Returns an array of Categorie objects sorted by last updated date
     */
    public function findCategoriesSortedByLastUpdated(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.lastUpdated', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
