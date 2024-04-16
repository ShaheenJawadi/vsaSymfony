<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SuggestionRepository;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: SuggestionRepository::class)]
#[ORM\Table(name: "suggestion", indexes: [new ORM\Index(name: "questionsId", columns: ["questionId"])])]
class Suggestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "suggestion", type: "string", length: 255)]
    #[Assert\NotBlank(message: "Les suggestions ne peuvent pas être vide.")]

    private ?string $suggestion = null;

    #[ORM\Column(name: "status", type: "boolean")]
    private ?bool $status = null;

    #[ORM\ManyToOne(targetEntity: Questions::class, inversedBy: "suggestions")]
    #[ORM\JoinColumn(name: "questionId", referencedColumnName: "id")]
    private ?Questions $questionId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuggestion(): ?string
    {
        return $this->suggestion;
    }

    public function setSuggestion(string $suggestion): self
    {
        $this->suggestion = $suggestion;
        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getQuestionId(): ?Questions
    {
        return $this->questionId;
    }

    public function setQuestionId(?Questions $questionId): self
    {
        $this->questionId = $questionId;
        return $this;
    }
}
