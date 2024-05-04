<?php

namespace App\Repository;

use App\Entity\Avis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AvisRepository extends ServiceEntityRepository
{
    /**
    * @method Avis[]    findAll()
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }

    // Ajoutez vos méthodes personnalisées ici
    public function getAll(): array
    {
        return $this->findAll();
    }
    public function getAvisByNote(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.note', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findAvisByCoursId(int $coursId): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.coursid = :coursId')
            ->setParameter('coursId', $coursId)
            ->getQuery()
            ->getResult();
    }
    public function findAvisById(int $id): ?Avis
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function getAverageNote(): float
    {
        $avisList = $this->findAll();
        $totalNotes = count($avisList);
        $sumNotes = 0;
    
        foreach ($avisList as $avis) {
            $sumNotes += $avis->getNote();
        }
    
        if ($totalNotes > 0) {
            $averageNote = $sumNotes / $totalNotes;
            return number_format($averageNote, 1); // Formatage avec deux chiffres après la virgule
        } else {
            return 0; // Vous pouvez choisir de retourner une valeur spécifique pour le cas où il n'y a pas de notes.
        }
    }
    
public function getCountByNote(int $note): int
{
    return $this->createQueryBuilder('a')
        ->select('COUNT(a.idAvi)')
        ->andWhere('a.note = :note')
        ->setParameter('note', $note)
        ->getQuery()
        ->getSingleScalarResult();
}



}
