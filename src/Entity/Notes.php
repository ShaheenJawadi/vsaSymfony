<?php

namespace App\Entity;

use App\Repository\NotesRepository;

use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]

//#[ORM\Entity(repositoryClass: NotesRepository::class)]
#[ORM\Table(name: "notes", indexes: [
    new ORM\Index(name: "userId", columns: ["userId"]),
    new ORM\Index(name: "quizId", columns: ["quizId"])
])]
class Notes
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "note", type: "float", precision: 10, scale: 0)]
    private ?float $note = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "id")]
    private ?User $userid = null;

    #[ORM\ManyToOne(targetEntity: Quiz::class)]
    #[ORM\JoinColumn(name: "quizId", referencedColumnName: "id")]
    private ?Quiz $quizid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): static
    {
        $this->note = $note;

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

    public function getQuizid(): ?Quiz
    {
        return $this->quizid;
    }

    public function setQuizid(?Quiz $quizid): static
    {
        $this->quizid = $quizid;

        return $this;
    }


}
