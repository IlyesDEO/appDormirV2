<?php

namespace App\Entity;

use App\Repository\LieuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;
/**
 * @Hateoas\Relation(
 *     "self",
 *     href= @Hateoas\Route(
 *          "lieux.get",
 *          parameters = { "idLieu" = "expr(object.getId())" } 
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getLieux")
 * )
 * @Hateoas\Relation(
 *     "self",
 *     href= @Hateoas\Route(
 *          "lieux.getAll",
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getAllLieux")
 * )
 * @Hateoas\Relation(
 *     "self",
 *     href= @Hateoas\Route(
 *          "lieuxStatus.get",
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getAllLieuxStatus")
 * )
 */

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

    #[ORM\Column(length: 255)]
    #[Groups(["getAllLieux", "getLieux", "getAllLieuxStatus"])]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'lieux')]
    #[Groups(["getAllLieux", "getLieux", "getAllLieuxStatus"])]
    private ?Ville $idVille = null;

    #[ORM\OneToOne(mappedBy: 'Lieux', cascade: ['persist', 'remove'])]
    private ?Notes $idNote = null;



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

    public function getIdNote(): ?Notes
    {
        return $this->idNote;
    }

    public function setIdNote(?Notes $idNote): self
    {
        // unset the owning side of the relation if necessary
        if ($idNote === null && $this->idNote !== null) {
            $this->idNote->setLieux(null);
        }

        // set the owning side of the relation if necessary
        if ($idNote !== null && $idNote->getLieux() !== $this) {
            $idNote->setLieux($this);
        }

        $this->idNote = $idNote;

        return $this;
    }

}
