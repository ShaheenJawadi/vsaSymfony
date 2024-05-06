<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity]

//#[ORM\Entity(repositoryClass: CallActionRepository::class)]
#[ORM\Table(name: "callaction", indexes: [
  
])]
class CallAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "content", type: "string", length: 255)]
    private ?string $content = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "target", type: "integer")]
    private ?string $target = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "given", type: "integer",  nullable: true)]
    private ?string $given = null;
 
    #[ORM\Column(name: "etat", type: "boolean")]
    private ?bool $etat = false;

   
 



    public function getId(): ?int
    {
        return $this->id;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }


    public function getTarget(): ?int
    {
        return $this->target;
    }
    
    public function setTarget(int $target): static
    {
        $this->target = $target;

        return $this;
    }

    public function getGiven(): ?int
    {
        return $this->given;
    }

    public function setGiven(?int $given): static
    {
        $this->given = $given;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
 
   
   
 

}
