<?php

namespace App\Entity;

use App\Repository\NotesRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NotesRepository::class)]
class Notes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getAllLieux", "getLieux", "getAllLieuxStatus"])]
    private ?int $note = null;

    #[ORM\OneToOne(inversedBy: 'idNote', cascade: ['persist', 'remove'])]
    private ?Lieux $Lieux = null;

    #[ORM\ManyToOne(inversedBy: 'idNote')]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getLieux(): ?Lieux
    {
        return $this->Lieux;
    }

    public function setLieux(?Lieux $Lieux): self
    {
        $this->Lieux = $Lieux;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
