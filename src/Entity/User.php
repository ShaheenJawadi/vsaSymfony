<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
#[ORM\Entity]

//#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "user", indexes: [new ORM\Index(name: "fk_level_id", columns: ["level_id"])])]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "nom", type: "string", length: 255)]
    private ?string $nom = null;

    #[ORM\Column(name: "prenom", type: "string", length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(name: "username", type: "string", length: 255)]
    private ?string $username = null;

    #[ORM\Column(name: "date_de_naissance", type: "date", nullable: true)]
    private ?\DateTimeInterface $dateDeNaissance = null;

    #[ORM\Column(name: "email", type: "string", length: 255)]
    private ?string $email = null;

    #[ORM\Column(name: "password", type: "string", length: 255)]
    private ?string $password = null;

    #[ORM\Column(name: "role", type: "string", length: 255, nullable: true)]
    private ?string $role = null;

    #[ORM\Column(name: "status", type: "string", length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(name: "token", type: "string", length: 255, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(name: "image", type: "string", length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(targetEntity: Level::class)]
    #[ORM\JoinColumn(name: "level_id", referencedColumnName: "id")]
    private ?Level $level = null;


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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(?\DateTimeInterface $dateDeNaissance): static
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): static
    {
        $this->role = $role;

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): static
    {
        $this->token = $token;

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

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): static
    {
        $this->level = $level;

        return $this;
    }


}
