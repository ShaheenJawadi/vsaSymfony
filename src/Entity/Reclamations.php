<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;

use Doctrine\DBAL\Types\Types;

//#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[ORM\Entity]
#[ORM\Table(name: "reclamations", indexes: [new ORM\Index(name: "id_user", columns: ["id_user"])])]
class Reclamations
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_reclamation", type: "integer")]
    private ?int $idReclamation = null;

    #[ORM\Column(name: "type", type: "string", length: 255)]
    private ?string $type = null;

    #[ORM\Column(name: "description", type: "string", length: 700)]
    private ?string $description = null;

    #[ORM\Column(name: "status", type: "string", length: 255)]
    private ?string $status = null;

    #[ORM\Column(name: "date", type: "date")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(name: "repondre", type: "boolean", nullable: true)]
    private ?bool $repondre = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id")]
    private ?User $idUser = null;

    public function getIdReclamation(): ?int
    {
        return $this->idReclamation;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    public function isRepondre(): ?bool
    {
        return $this->repondre;
    }

    public function setRepondre(?bool $repondre): static
    {
        $this->repondre = $repondre;

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


}
