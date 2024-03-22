<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LevelRepository;

#[ORM\Entity]

//#[ORM\Entity(repositoryClass: LevelRepository::class)]
#[ORM\Table(name: "level")]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "niveau", type: "string", length: 255)]
    private ?string $niveau = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }


}
