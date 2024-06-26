<?php

namespace App\Entity;

use App\Repository\MachineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MachineRepository::class)]
class Machine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, Poste>
     */
    #[ORM\ManyToMany(targetEntity: Poste::class, inversedBy: 'machines')]
    private Collection $Poste;

    /**
     * @var Collection<int, Operation>
     */
    #[ORM\OneToMany(mappedBy: 'machine_id', targetEntity: Operation::class)]
    private Collection $operations;

    /**
     * @var Collection<int, Realisation>
     */
    #[ORM\OneToMany(mappedBy: 'machine_reel', targetEntity: Realisation::class)]
    private Collection $realisations;

    public function __construct()
    {
        $this->Poste = new ArrayCollection();
        $this->operations = new ArrayCollection();
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

    /**
     * @return Collection<int, Poste>
     */
    public function getPoste(): Collection
    {
        return $this->Poste;
    }

    public function addPoste(Poste $poste): static
    {
        if (!$this->Poste->contains($poste)) {
            $this->Poste->add($poste);
            $poste->addMachine($this);
        }

        return $this;
    }

    public function removePoste(Poste $poste): static
    {
        $this->Poste->removeElement($poste);
        $poste->removeMachine($this);

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
            $operation->setMachine($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning se to null (unless already changed)
            if ($operation->getMachine() === $this) {
                $operation->setMachine(null);
            }
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
            $realisation->setMachineReel($this);
        }

        return $this;
    }

    public function removeRealisation(Realisation $realisation): static
    {
        if ($this->realisations->removeElement($realisation)) {
            // set the owning se to null (unless already changed)
            if ($realisation->getMachineReel() === $this) {
                $realisation->setMachineReel(null);
            }
        }

        return $this;
    }
}
