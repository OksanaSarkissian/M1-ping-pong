<?php

namespace App\Entity;

use App\Repository\PieceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
class Piece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $ref_piece = null;

    #[ORM\Column(length: 100)]
    private ?string $libelle_piece = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix_unitaire = null;

    #[ORM\Column]
    private ?int $stock = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'pieces')]
    private Collection $composition;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'composition')]
    private Collection $pieces;

    #[ORM\OneToOne(inversedBy: 'piece', cascade: ['persist', 'remove'])]
    private ?Gamme $gamme = null;

    public function __construct()
    {
        $this->composition = new ArrayCollection();
        $this->pieces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefPiece(): ?string
    {
        return $this->ref_piece;
    }

    public function setRefPiece(string $ref_piece): static
    {
        $this->ref_piece = $ref_piece;

        return $this;
    }

    public function getLibellePiece(): ?string
    {
        return $this->libelle_piece;
    }

    public function setLibellePiece(string $libelle_piece): static
    {
        $this->libelle_piece = $libelle_piece;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(?float $prix_unitaire): static
    {
        $this->prix_unitaire = $prix_unitaire;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getComposition(): Collection
    {
        return $this->composition;
    }

    public function addComposition(self $composition): static
    {
        if (!$this->composition->contains($composition)) {
            $this->composition->add($composition);
        }

        return $this;
    }

    public function removeComposition(self $composition): static
    {
        $this->composition->removeElement($composition);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(self $piece): static
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces->add($piece);
            $piece->addComposition($this);
        }

        return $this;
    }

    public function removePiece(self $piece): static
    {
        if ($this->pieces->removeElement($piece)) {
            $piece->removeComposition($this);
        }

        return $this;
    }

    public function getGamme(): ?Gamme
    {
        return $this->gamme;
    }

    public function setGammeFromGamme(?Gamme $gamme): static
    {
        $this->gamme = $gamme;

        return $this;
    }
    public function setGamme(?Gamme $gamme): static
    {
        // unset the owning side of the relation if necessary
        if ($gamme === null && $this->gamme !== null) {
            $this->gamme->setPieceFromPiece(null);
        }

        // set the owning side of the relation if necessary
        if ($gamme !== null && $gamme->getPiece() !== $this) {
            $gamme->setPieceFromPiece($this);
        }

        $this->gamme = $gamme;

        return $this;
    }

}
