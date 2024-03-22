<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SouscategorieRepository;
#[ORM\Entity]

//#[ORM\Entity(repositoryClass: SouscategorieRepository::class)]
#[ORM\Table(name: "souscategorie", indexes: [new ORM\Index(name: "categorieId", columns: ["categorieId"])])]
class Souscategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "nom", type: "string", length: 255)]
    private ?string $nom = null;

    #[ORM\Column(name: "description", type: "string", length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: "images", type: "string", length: 600, nullable: true)]
    private ?string $images = null;

    #[ORM\Column(name: "status", type: "string", length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(name: "dateCreation", type: "date", nullable: true)]
    private ?\DateTimeInterface $datecreation = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    #[ORM\JoinColumn(name: "categorieId", referencedColumnName: "id")]
    private ?Categorie $categorieid = null;
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

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(?\DateTimeInterface $datecreation): static
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getCategorieid(): ?Categorie
    {
        return $this->categorieid;
    }

    public function setCategorieid(?Categorie $categorieid): static
    {
        $this->categorieid = $categorieid;

        return $this;
    }


}
