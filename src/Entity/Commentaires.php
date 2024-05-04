<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentairesRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentairesRepository::class)]
#[ORM\Table(name: "commentaires", indexes: [
    new ORM\Index(name: "user_id", columns: ["user_id"]),
    new ORM\Index(name: "id_pub", columns: ["id_pub"])
])]
class Commentaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "commentaire", type: "string", length: 500)]
    #[Assert\NotBlank(message: "Le commentaire ne peut pas être vide.")]

    private ?string $commentaire = null;

    #[ORM\Column(name: "date", type: "datetime")]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(targetEntity: Publications::class)]
    #[ORM\JoinColumn(name: "id_pub", referencedColumnName: "id")]
    private ?Publications $idPub = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

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

    public function getIdPub(): ?Publications
    {
        return $this->idPub;
    }

    public function setIdPub(?Publications $idPub): static
    {
        $this->idPub = $idPub;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }


}
