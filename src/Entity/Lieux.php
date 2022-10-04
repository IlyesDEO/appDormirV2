<?php

namespace App\Entity;

use App\Repository\LieuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LieuxRepository::class)]
class Lieux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getAllLieux", "getLieux"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getAllLieux", "getLieux"])]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $note = null;


    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'lieux')]
    private ?self $idVille = null;

    #[ORM\OneToMany(mappedBy: 'idVille', targetEntity: self::class)]
    private Collection $lieux;

    #[ORM\ManyToOne(inversedBy: 'lieux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $idCat = null;

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

    public function getIdVille(): ?self
    {
        return $this->idVille;
    }

    public function setIdVille(?self $idVille): self
    {
        $this->idVille = $idVille;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getLieux(): Collection
    {
        return $this->lieux;
    }

    public function addLieux(self $lieux): self
    {
        if (!$this->lieux->contains($lieux)) {
            $this->lieux->add($lieux);
            $lieux->setIdVille($this);
        }

        return $this;
    }

    public function removeLieux(self $lieux): self
    {
        if ($this->lieux->removeElement($lieux)) {
            // set the owning side to null (unless already changed)
            if ($lieux->getIdVille() === $this) {
                $lieux->setIdVille(null);
            }
        }

        return $this;
    }

    public function getIdCat(): ?Categorie
    {
        return $this->idCat;
    }

    public function setIdCat(?Categorie $idCat): self
    {
        $this->idCat = $idCat;

        return $this;
    }
}
