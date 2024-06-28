<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $temps = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Poste $poste = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Machine $machine = null;

    /**
     * @var Collection<int, Gamme>
     */
    #[ORM\ManyToMany(targetEntity: Gamme::class, mappedBy: 'operations')]
    private Collection $gammes;

    /**
     * @var Collection<int, Realisation>
     */
    #[ORM\OneToMany(mappedBy: 'operation', targetEntity: Realisation::class)]
    private Collection $realisations;

    public function __construct()
    {
        $this->gammes = new ArrayCollection();
        $this->realisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTemps(): ?\DateTimeInterface
    {
        return $this->temps;
    }

    public function setTemps(\DateTimeInterface $temps): static
    {
        $this->temps = $temps;

        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getMachine(): ?Machine
    {
        return $this->machine;
    }

    public function setMachine(?Machine $machine): static
    {
        $this->machine = $machine;

        return $this;
    }

    /**
     * @return Collection<int, Gamme>
     */
    public function getGammes(): Collection
    {
        return $this->gammes;
    }

    public function addGamme(Gamme $gamme): static
    {
        if (!$this->gammes->contains($gamme)) {
            $this->gammes->add($gamme);
            $gamme->addOperation($this);
        }

        return $this;
    }

    public function removeGamme(Gamme $gamme): static
    {
        if ($this->gammes->removeElement($gamme)) {
            $gamme->removeOperation($this);
        }

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
            $realisation->setOperation($this);
        }

        return $this;
    }

    public function removeRealisation(Realisation $realisation): static
    {
        if ($this->realisations->removeElement($realisation)) {
            // set the owning side to null (unless already changed)
            if ($realisation->getOperation() === $this) {
                $realisation->setOperation(null);
            }
        }

        return $this;
    }
}
