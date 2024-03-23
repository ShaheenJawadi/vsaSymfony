<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReactionsRepository;
#[ORM\Entity]

//#[ORM\Entity(repositoryClass: ReactionsRepository::class)]
#[ORM\Table(name: "reactions", indexes: [
    new ORM\Index(name: "fk_user_reactions", columns: ["user_id"]),
    new ORM\Index(name: "fk_pub_reactions", columns: ["pub_id"])
])]
class Reactions
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "jaime", type: "integer")]
    private ?int $jaime = null;

    #[ORM\Column(name: "dislike", type: "integer")]
    private ?int $dislike = null;

    #[ORM\ManyToOne(targetEntity: Publications::class)]
    #[ORM\JoinColumn(name: "pub_id", referencedColumnName: "id")]
    private ?Publications $pub = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJaime(): ?int
    {
        return $this->jaime;
    }

    public function setJaime(int $jaime): static
    {
        $this->jaime = $jaime;

        return $this;
    }

    public function getDislike(): ?int
    {
        return $this->dislike;
    }

    public function setDislike(int $dislike): static
    {
        $this->dislike = $dislike;

        return $this;
    }

    public function getPub(): ?Publications
    {
        return $this->pub;
    }

    public function setPub(?Publications $pub): static
    {
        $this->pub = $pub;

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
