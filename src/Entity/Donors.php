<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity]

//#[ORM\Entity(repositoryClass: DonorsRepository::class)]
#[ORM\Table(name: "donors", indexes: [
    new ORM\Index(name: "userId", columns: ["userId"]),
])]
class Donors
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

 

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "id")]
    private ?User $userId = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "montant", type: "integer",  nullable: true)]
    private ?string $montant = null;
 
   
   
 



    public function getId(): ?int
    {
        return $this->id;
    }
 

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }


    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

  
   
   
 

}
