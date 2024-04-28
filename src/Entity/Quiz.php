<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuizRepository;
use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\NotBlank(message: "Le nom du quiz ne peut pas être vide.")]

    private ?string $nom = null;

    #[ORM\Column(name: "duree", type: "string", length: 255)]
    #[Assert\NotBlank(message: "La durée quiz ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/",
        message: "Le format de la durée doit être hh:mm:ss"
    )]
    #[Assert\NotEqualTo(
        value: "00:00:00",
        message: "La durée ne peut pas être 00:00:00."
    )]
    private ?string $duree = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "id")]
    private ?User $userid = null;

    #[ORM\ManyToOne(targetEntity: Cours::class)]
    #[ORM\JoinColumn(name: "coursId", referencedColumnName: "id")]
    private ?Cours $coursid = null;

    #[ORM\OneToMany(targetEntity: Questions::class, mappedBy: "quizId", cascade: ["persist", "remove"])]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;
        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userid;
    }

    public function setUserId(?User $userId): self
    {
        $this->userid = $userId;
        return $this;
    }

    public function getCoursId(): ?Cours
    {
        return $this->coursid;
    }

    public function setCoursId(?Cours $coursId): self
    {
        $this->coursid = $coursId;
        return $this;
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function setQuestions(Collection $questions): self
    {
        $this->questions = $questions;
        return $this;
    }
}
