<?php

namespace App\Entity;

use App\Repository\GammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: GammeRepository::class)]
class Gamme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'gammes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $responsable = null;

    #[ORM\OneToOne(inversedBy: 'gamme', cascade: ['persist', 'remove'])]
    private ?Piece $piece = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, Operation>
     */
    #[ORM\ManyToMany(targetEntity: Operation::class, inversedBy: 'gammes')]
    private Collection $operations;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponsable(): ?User
    {
        return $this->responsable;
    }

    public function setResponsable(?User $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Operation>
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): static
    {
        if (!$this->operations->contains($operation)) {
            $this->operations->add($operation);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): static
    {
        $this->operations->removeElement($operation);

        return $this;
    }

    public function getPiece(): ?Piece
    {
        return $this->piece;
    }

    public function setPieceFromPiece(?Piece $piece):static{
        $this->piece = $piece;

        return $this;
    }

    public function setPiece(?Piece $piece): static
    {
        // unset the owning side of the relation if necessary
        if ($piece === null && $this->piece !== null) {
            $this->piece->setGammeFromGamme(null);
        }

        // set the owning side of the relation if necessary
        if ($piece !== null && $piece->getGamme() !== $this) {
            $piece->setGammeFromGamme($this);
        }

        $this->piece = $piece;

        return $this;
    }
}
