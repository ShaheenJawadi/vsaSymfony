<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuizRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
#[ORM\Entity(repositoryClass: QuizRepository::class)]
#[ORM\Table(name: "quiz", indexes: [
    new ORM\Index(name: "coursId", columns: ["coursId"]),
    new ORM\Index(name: "userId", columns: ["userId"])
])]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "nom", type: "string", length: 255)]
    private ?string $nom = null;

    #[ORM\Column(name: "duree", type: "string", length: 255)]
    private ?string $duree = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "id")]
    private ?User $userid = null;

    #[ORM\ManyToOne(targetEntity: Cours::class)]
    #[ORM\JoinColumn(name: "coursId", referencedColumnName: "id")]
    private ?Cours $coursid = null;

    
    #[ORM\OneToMany(targetEntity: Questions::class,mappedBy:"quizid")]

    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): static
    {
        $this->userid = $userid;

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
