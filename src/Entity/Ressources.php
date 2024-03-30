<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RessourcesRepository;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity]

//#[ORM\Entity(repositoryClass: RessourcesRepository::class)]
#[ORM\Table(name: "ressources", indexes: [new ORM\Index(name: "coursId", columns: ["coursId"])])]
class Ressources
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;
    #[Assert\NotBlank]
    #[ORM\Column(name: "lien", type: "string", length: 250)]
    private ?string $lien = null;
    #[Assert\NotBlank]
    #[ORM\Column(name: "type", type: "string", length: 60)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Cours::class)]
    #[ORM\JoinColumn(name: "coursId", referencedColumnName: "id")]
    private ?Cours $coursid = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): static
    {
        $this->lien = $lien;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCoursid(): ?Cours
    {
        return $this->coursid;
    }

    public function setCoursid(?Cours $coursid): static
    {
        $this->coursid = $coursid;

        return $this;
    }


}
