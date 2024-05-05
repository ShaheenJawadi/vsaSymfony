<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LessonsRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]

//#[ORM\Entity(repositoryClass: LessonsRepository::class)]
#[ORM\Table(name: "lessons", indexes: [new ORM\Index(name: "coursId", columns: ["coursId"])])]
class Lessons
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "titre", type: "string", length: 80)]
    private ?string $titre = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "content", type: "text")]
    private ?string $content = null;

    #[Assert\NotNull]
    #[Assert\Positive]
    #[ORM\Column(name: "duree", type: "integer", nullable: true)]
    private ?int $duree = null;

    #[ORM\Column(name: "image", type: "string", length: 255, nullable: true)]
    private ?string $image = null;

    #[Assert\Url]
    #[ORM\Column(name: "video", type: "string", length: 80, nullable: true)]
    private ?string $video = null;

   
    #[Assert\Positive]
    #[ORM\Column(name: "classement", type: "integer")]
    private ?int $classement = 0;

    #[ORM\ManyToOne(targetEntity: Cours::class)]
    #[ORM\JoinColumn(name: "coursId", referencedColumnName: "id")]
    private ?Cours $coursid = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
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

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): static
    {
        $this->duree = $duree;

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

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): static
    {
        $this->video = $video;

        return $this;
    }

    public function getClassement(): ?int
    {
        return $this->classement;
    }

    public function setClassement(int $classement): static
    {
        $this->classement = $classement;

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
