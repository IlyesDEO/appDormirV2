<?php

namespace App\Entity;

use App\Repository\LieuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LieuxRepository::class)]
class Lieux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getAllLieux", "getLieux", "getAllLieuxStatus"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getAllLieux", "getLieux", "getAllLieuxStatus"])]
    #[Assert\NotNull(message:'Un lieu doit avoir une description')]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(["getAllLieux", "getLieux", "getAllLieuxStatus"])]
    private ?int $note = null;


    #[ORM\Column(length: 255)]
    #[Groups(["getAllLieux", "getLieux", "getAllLieuxStatus"])]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'lieux')]
    private ?Ville $idVille = null;

    public function __construct()
    {
        $this->lieux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }


    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIdVille(): ?Ville
    {
        return $this->idVille;
    }

    public function setIdVille(?Ville $idVille): self
    {
        $this->idVille = $idVille;

        return $this;
    }
}
