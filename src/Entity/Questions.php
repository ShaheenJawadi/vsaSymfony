<?php

namespace App\Entity;
use App\Repository\QuestionsRepository;

use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]

//#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
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
    private ?string $question = null;

    #[ORM\Column(name: "image", type: "string", length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(targetEntity: Quiz::class)]
    #[ORM\JoinColumn(name: "quizId", referencedColumnName: "id")]
    private ?Quiz $quizid = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "id")]
    private ?User $userid = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

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

    public function getQuizid(): ?Quiz
    {
        return $this->quizid;
    }

    public function setQuizid(?Quiz $quizid): static
    {
        $this->quizid = $quizid;

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


}
