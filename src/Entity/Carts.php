<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity]

//#[ORM\Entity(repositoryClass: CartsRepository::class)]
#[ORM\Table(name: "carts", indexes: [
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
    #[ORM\Column(name: "total_price", type: "integer",  nullable: true)]
    private ?string $total_price = null;
 

    #[Assert\NotBlank]
    #[ORM\Column(name: "adresse", type: "string", length: 255, nullable: true)]
    private ?string $adresse = null;
    
    #[Assert\NotBlank]
    #[ORM\Column(name: "etat", type: "string", length: 255, nullable: true)]
    private ?string $etat = null;
   
 



    public function getId(): ?int
    {
        return $this->id;
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

  



    
    public function getTotalPrice(): ?int
    {
        return $this->total_price;
    }

    public function setTotalPrice(?int $total_price): static
    {
        $this->total_price = $total_price;

        return $this;
    }
   
   
 

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }



    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

}
