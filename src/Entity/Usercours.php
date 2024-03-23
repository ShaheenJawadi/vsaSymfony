<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsercoursRepository;
#[ORM\Entity]

//#[ORM\Entity(repositoryClass: UsercoursRepository::class)]
#[ORM\Table(name: "usercours", indexes: [
    new ORM\Index(name: "userId", columns: ["userId"]),
    new ORM\Index(name: "coursId", columns: ["coursId"])
])]
class Usercours
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "isCorrectQuizz", type: "boolean")]
    private ?bool $iscorrectquizz = false;

    #[ORM\Column(name: "stage", type: "integer")]
    private ?int $stage = 0;

    #[ORM\Column(name: "isCompleted", type: "boolean")]
    private ?bool $iscompleted = false;

    #[ORM\Column(name: "enrollmentDate", type: "date", options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeInterface $enrollmentdate;

    #[ORM\Column(name: "completedDate", type: "date", nullable: true)]
    private ?\DateTimeInterface $completeddate = null;

    #[ORM\ManyToOne(targetEntity: Cours::class)]
    #[ORM\JoinColumn(name: "coursId", referencedColumnName: "id")]
    private ?Cours $coursid = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "id")]
    private ?User $userid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIscorrectquizz(): ?bool
    {
        return $this->iscorrectquizz;
    }

    public function setIscorrectquizz(bool $iscorrectquizz): static
    {
        $this->iscorrectquizz = $iscorrectquizz;

        return $this;
    }

    public function getStage(): ?int
    {
        return $this->stage;
    }

    public function setStage(int $stage): static
    {
        $this->stage = $stage;

        return $this;
    }

    public function isIscompleted(): ?bool
    {
        return $this->iscompleted;
    }

    public function setIscompleted(bool $iscompleted): static
    {
        $this->iscompleted = $iscompleted;

        return $this;
    }

    public function getEnrollmentdate(): ?\DateTimeInterface
    {
        return $this->enrollmentdate;
    }

    public function setEnrollmentdate(\DateTimeInterface $enrollmentdate): static
    {
        $this->enrollmentdate = $enrollmentdate;

        return $this;
    }

    public function getCompleteddate(): ?\DateTimeInterface
    {
        return $this->completeddate;
    }

    public function setCompleteddate(?\DateTimeInterface $completeddate): static
    {
        $this->completeddate = $completeddate;

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

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): static
    {
        $this->userid = $userid;

        return $this;
    }


}
