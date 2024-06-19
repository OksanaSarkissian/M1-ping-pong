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

    #[ORM\Column(length: 255)]
    private ?string $reference_piece = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle_piece = null;

    #[ORM\Column]
    private ?float $prix_u = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\OneToOne(inversedBy: 'piece', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gamme $gamme_id = null;

    /**
     * @var Collection<int, Realisation>
     */
    #[ORM\OneToMany(mappedBy: 'piece', targetEntity: Realisation::class)]
    private Collection $realisations;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'composition')]
    private Collection $composition;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $qtt_piece;

    public function __construct()
    {
        $this->realisations = new ArrayCollection();
        $this->composition = new ArrayCollection();
        $this->qtt_piece = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferencePiece(): ?string
    {
        return $this->reference_piece;
    }

    public function setReferencePiece(string $reference_piece): static
    {
        $this->reference_piece = $reference_piece;

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

    public function getPrixU(): ?float
    {
        return $this->prix_u;
    }

    public function setPrixU(float $prix_u): static
    {
        $this->prix_u = $prix_u;

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

    public function getGammeId(): ?Gamme
    {
        return $this->gamme_id;
    }

    public function setGammeId(Gamme $gamme_id): static
    {
        $this->gamme_id = $gamme_id;

        return $this;
    }

    /**
     * @return Collection<int, Realisation>
     */
    public function getRealisations(): Collection
    {
        return $this->realisations;
    }

    public function addRealisation(Realisation $realisation): static
    {
        if (!$this->realisations->contains($realisation)) {
            $this->realisations->add($realisation);
            $realisation->setPiece($this);
        }

        return $this;
    }

    public function removeRealisation(Realisation $realisation): static
    {
        if ($this->realisations->removeElement($realisation)) {
            // set the owning side to null (unless already changed)
            if ($realisation->getPiece() === $this) {
                $realisation->setPiece(null);
            }
        }

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

}
