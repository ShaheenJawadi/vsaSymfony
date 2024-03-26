<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SuggestionRepository;

#[ORM\Entity(repositoryClass: SuggestionRepository::class)]
#[ORM\Table(name: "suggestion", indexes: [new ORM\Index(name: "questionsId", columns: ["questionId"])])]
class Suggestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "suggestion", type: "string", length: 255)]
    private ?string $suggestion = null;

    #[ORM\Column(name: "status", type: "boolean")]
    private ?bool $status = null;

    #[ORM\ManyToOne(targetEntity: Questions::class)]
    #[ORM\JoinColumn(name: "questionId", referencedColumnName: "id")]
    private ?Questions $questionid = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuggestion(): ?string
    {
        return $this->suggestion;
    }

    public function setSuggestion(string $suggestion): static
    {
        $this->suggestion = $suggestion;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getQuestionid(): ?Questions
    {
        return $this->questionid;
    }

    public function setQuestionid(?Questions $questionid): static
    {
        $this->questionid = $questionid;

        return $this;
    }


}
