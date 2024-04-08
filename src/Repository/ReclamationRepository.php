<?php

namespace App\Repository;
use App\Entity\Reclamations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReclamationRepository extends ServiceEntityRepository{
        /**
    * @method Reclamations[]    findAll()
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamations::class);
    }
        // Ajoutez vos méthodes personnalisées ici
        public function getAll(): array
        {
            return $this->findAll();
        }

}