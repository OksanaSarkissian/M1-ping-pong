<?php

namespace App\Entity;

use App\Repository\AchatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: AchatRepository::class)]
#[Broadcast]
class Achat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $livraison_prevue = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $livraison_reelle = null;

    /**
     * @var Collection<int, LigneAchat>
     */
    #[ORM\OneToMany(mappedBy: 'achat', targetEntity: LigneAchat::class)]
    private Collection $ligneAchats;

    #[ORM\ManyToOne(inversedBy: 'achats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $fournisseur = null;

    public function __construct()
    {
        $this->ligneAchats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getLivraisonPrevue(): ?\DateTimeImmutable
    {
        return $this->livraison_prevue;
    }

    public function setLivraisonPrevue(\DateTimeImmutable $livraison_prevue): static
    {
        $this->livraison_prevue = $livraison_prevue;

        return $this;
    }

    public function getLivraisonReelle(): ?\DateTimeImmutable
    {
        return $this->livraison_reelle;
    }

    public function setLivraisonReelle(?\DateTimeImmutable $livraison_reelle): static
    {
        $this->livraison_reelle = $livraison_reelle;

        return $this;
    }

    /**
     * @return Collection<int, LigneAchat>
     */
    public function getLigneAchats(): Collection
    {
        return $this->ligneAchats;
    }

    public function addLigneAchat(LigneAchat $ligneAchat): static
    {
        if (!$this->ligneAchats->contains($ligneAchat)) {
            $this->ligneAchats->add($ligneAchat);
            $ligneAchat->setAchat($this);
        }

        return $this;
    }

    public function removeLigneAchat(LigneAchat $ligneAchat): static
    {
        if ($this->ligneAchats->removeElement($ligneAchat)) {
            // set the owning side to null (unless already changed)
            if ($ligneAchat->getAchat() === $this) {
                $ligneAchat->setAchat(null);
            }
        }

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }
}
