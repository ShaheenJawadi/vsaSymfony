<?php

namespace App\Entity;
use App\Repository\PublicationsRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PublicationsRepository::class)]
#[ORM\Table(name: "publications", indexes: [new ORM\Index(name: "user_id", columns: ["user_id"])])]

class Publications
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "titre", type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le titre ne peut pas être vide.")]
    #[Assert\Length(
        max: 30,
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $titre = null;

    #[ORM\Column(name: "contenu", type: "string", length: 500)]
    #[Assert\NotBlank(message: "Le contenu ne peut pas être vide.")]
    #[Assert\Length(
        max: 500,
        maxMessage: "Le contenu ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $contenu = null;

    #[ORM\Column(name: "images", type: "string", length: 600)]
    private ?string $images = null;

    #[ORM\Column(name: "date_creation", type: "datetime")]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(name: "nbClicks", type: "integer", nullable: true)]
    private ?int $nbclicks = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity:Commentaires::class, mappedBy:"idPub")]
    private $commentaires;

    public function __construct() {
        $this->commentaires = new ArrayCollection();
    }
    
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }
    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images ? explode(';', $this->images) : null;
    }

    public function setImages(array|string $images): static
    {
        if (is_array($images)) {
            $this->images = implode(';', $images);
        } else {
            $this->images = $images;
        }

        return $this;
    }


    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getNbclicks(): ?int
    {
        return $this->nbclicks;
    }

    public function setNbclicks(?int $nbclicks): static
    {
        $this->nbclicks = $nbclicks;

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
