<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity]

//#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[ORM\Table(name: "products", indexes: [
  
])]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "prix", type: "integer")]
    private ?string $prix = null;

 
 
    #[Assert\NotBlank]
    #[ORM\Column(name: "title", type: "string", length: 255, nullable: true)]
    private ?string $title = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "image", type: "string", length: 255, nullable: true)]
    private ?string $image = null;



    #[Assert\NotBlank]
    #[ORM\Column(name: "description", type: "string", length: 255, nullable: true)]
    private ?string $description = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "tags", type: "string", length: 255, nullable: true)]
    private ?string $tags = null;
    


   
 



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }
    
    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }



   
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

   

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
 


    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): static
    {
        $this->tags = $tags;

        return $this;
    }



}
