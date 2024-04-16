<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CoursRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]

//#[ORM\Entity(repositoryClass: CoursRepository::class)]
#[ORM\Table(name: "cours", indexes: [
    new ORM\Index(name: "subCategoryId", columns: ["subCategoryId"]),
    new ORM\Index(name: "niveauId", columns: ["niveauId"]),
    new ORM\Index(name: "enseignantId", columns: ["enseignantId"])
])]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "nom", type: "string", length: 80)]
    private ?string $nom = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "image", type: "string", length: 255, nullable: true)]
    private ?string $image = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: "description", type: "text")]
    private ?string $description = null;

    #[ORM\Column(name: "tags", type: "string", length: 60, nullable: true)]
    private ?string $tags = null;

    #[ORM\Column(name: "isValidated", type: "boolean")]
    private ?bool $isvalidated = false;

    #[Assert\NotBlank]
    #[ORM\Column(name: "slug", type: "string", length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(name: "views", type: "integer", nullable: true)]
    private ?int $views = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Souscategorie::class)]
    #[ORM\JoinColumn(name: "subCategoryId", referencedColumnName: "id")]
    private ?Souscategorie $subcategoryid = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Level::class)]
    #[ORM\JoinColumn(name: "niveauId", referencedColumnName: "id")]
    private ?Level $niveauid = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "enseignantId", referencedColumnName: "id")]
    private ?User $enseignantid = null;



    #[ORM\OneToMany(targetEntity:Lessons::class, mappedBy:"coursid")]
    private Collection $lessons;

    #[ORM\OneToOne(targetEntity:Ressources::class, mappedBy:"coursid")]
    private Ressources $ressource;

    public function __construct() {
        $this->lessons = new ArrayCollection();
    }
    
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function getRessource(): ?Ressources
    {
        return $this->ressource;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    public function isIsvalidated(): ?bool
    {
        return $this->isvalidated;
    }

    public function setIsvalidated(bool $isvalidated): static
    {
        $this->isvalidated = $isvalidated;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): static
    {
        $this->views = $views;

        return $this;
    }

    public function getSubcategoryid(): ?Souscategorie
    {
        return $this->subcategoryid;
    }

    public function setSubcategoryid(?Souscategorie $subcategoryid): static
    {
        $this->subcategoryid = $subcategoryid;

        return $this;
    }

    public function getNiveauid(): ?Level
    {
        return $this->niveauid;
    }

    public function setNiveauid(?Level $niveauid): static
    {
        $this->niveauid = $niveauid;

        return $this;
    }

    public function getEnseignantid(): ?User
    {
        return $this->enseignantid;
    }

    public function setEnseignantid(?User $enseignantid): static
    {
        $this->enseignantid = $enseignantid;

        return $this;
    }


}
