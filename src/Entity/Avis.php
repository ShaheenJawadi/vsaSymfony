<?php

namespace App\Entity;
use App\Repository\AvisRepository;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


//#[ORM\Entity(repositoryClass: AvisRepository::class)]
#[ORM\Entity]
#[ORM\Table(name: "avis", indexes: [
    new ORM\Index(name: "id_user", columns: ["id_user"]),
    new ORM\Index(name: "coursId", columns: ["coursId"])
])]

class Avis
{
    #[ORM\Id]
    #[ORM\Column(name: "id_avi", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idAvi = null;

    #[ORM\Column(name: "note", type: "integer")]
    private ?int $note = null;

    #[ORM\Column(name: "message", type: "string", length: 255)]
    private ?string $message = null;

    #[ORM\Column(name: "date", type: "date")]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id")]
    private ?User $idUser = null;

    #[ORM\ManyToOne(targetEntity: Cours::class)]
    #[ORM\JoinColumn(name: "coursId", referencedColumnName: "id")]
    private ?Cours $coursid = null;

    public function getIdAvi(): ?int
    {
        return $this->idAvi;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

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
