<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuestionsRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
#[ORM\Table(name: "questions", indexes: [
    new ORM\Index(name: "quizId", columns: ["quizId"]),
    new ORM\Index(name: "userId", columns: ["userId"])
])]
class Questions
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "question", type: "string", length: 255)]
    #[Assert\NotBlank(message: "La question ne peut pas être vide.")]

    private ?string $question = null;

    #[ORM\Column(name: "image", type: "string", length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(targetEntity: Quiz::class)]
    #[ORM\JoinColumn(name: "quizId", referencedColumnName: "id")]
    private ?Quiz $quizId = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "id")]
    private ?User $userId = null;

    #[ORM\OneToMany(targetEntity: Suggestion::class, mappedBy: "questionId", cascade: ["persist", "remove"])]
    private Collection $suggestions;

    public function __construct()
    {
        $this->suggestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getQuizId(): ?Quiz
    {
        return $this->quizId;
    }

    public function setQuizId(?Quiz $quizId): self
    {
        $this->quizId = $quizId;
        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getSuggestions(): Collection
    {
        return $this->suggestions;
    }

    public function setSuggestions(Collection $suggestions): self
    {
        $this->suggestions = $suggestions;
        return $this;
    }
}
