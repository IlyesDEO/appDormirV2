<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getAllLieux", "getLieux", "getAllLieuxStatus"])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(["getAllLieux", "getLieux", "getAllLieuxStatus"])]
    private ?string $nomVille = null;

    #[ORM\Column]
    private ?bool $status = null;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArrondissement(): ?string
    {
        return $this->arrondissement;
    }

    public function setArrondissement(string $arrondissement): self
    {
        $this->arrondissement = $arrondissement;

        return $this;
    }


    public function getNomVille(): ?string
    {
        return $this->nomVille;
    }

    public function setNomVille(string $nomVille): self
    {
        $this->nomVille = $nomVille;

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


}
