<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

//#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ORM\Entity]
#[ORM\Table(name: "categorie")]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "nom", type: "string", length: 255)]
    private ?string $nom = null;

    #[ORM\Column(name: "description", type: "string", length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: "last_updated", type: "date", nullable: true)]
    private ?\DateTimeInterface $lastUpdated = null;

    #[ORM\Column(name: "image", type: "string", length: 600, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(name: "nbSousCategorie", type: "integer", nullable: false , options: ["default" => "0"])]
    private ?int $nbsouscategorie = 0;

    #[ORM\OneToMany(targetEntity:"App\Entity\Souscategorie", mappedBy:"categorie")]
    private $souscategories;

    public function __construct()
    {
        $this->souscategories = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLastUpdated(): ?\DateTimeInterface
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(?\DateTimeInterface $lastUpdated): static
    {
        $this->lastUpdated = $lastUpdated;

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

    public function getNbsouscategorie(): ?int
    {
        return $this->nbsouscategorie;
    }

    public function setNbsouscategorie(?int $nbsouscategorie): static
    {
        $this->nbsouscategorie = $nbsouscategorie;

        return $this;
    }

    /**
     * @return Collection|Souscategorie[]
     */
    public function getSouscategories(): Collection
    {
        return $this->souscategories;
    }


}
