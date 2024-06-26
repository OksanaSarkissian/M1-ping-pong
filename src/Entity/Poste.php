<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosteRepository::class)]
class Poste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'postes')]
    private Collection $id_user;

    /**
     * @var Collection<int, Machine>
     */
    #[ORM\ManyToMany(targetEntity: Machine::class, inversedBy: 'Poste')]
    private Collection $machines;

    /**
     * @var Collection<int, Operation>
     */
    #[ORM\OneToMany(mappedBy: 'poste_id', targetEntity: Operation::class)]
    private Collection $operations;

    /**
     * @var Collection<int, Realisation>
     */
    #[ORM\OneToMany(mappedBy: 'poste_reel', targetEntity: Realisation::class)]
    private Collection $realisations;

    /**
     * @var Collection<int, Machine>
     */
    #[ORM\ManyToMany(targetEntity: Machine::class, mappedBy: 'poste2')]
    private Collection $machines2;

    public function __construct()
    {
        $this->id_user = new ArrayCollection();
        $this->machines = new ArrayCollection();
        $this->operations = new ArrayCollection();
        $this->realisations = new ArrayCollection();
        $this->machines2 = new ArrayCollection();
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
     * @return Collection<int, User>
     */
    public function getIdUser(): Collection
    {
        return $this->id_user;
    }

    public function addIdUser(User $idUser): static
    {
        if (!$this->id_user->contains($idUser)) {
            $this->id_user->add($idUser);
        }

        return $this;
    }

    public function removeIdUser(User $idUser): static
    {
        $this->id_user->removeElement($idUser);

        return $this;
    }

    /**
     * @return Collection<int, Machine>
     */
    public function getMachines(): Collection
    {
        return $this->machines;
    }

    public function addMachine(Machine $machine): static
    {
        if (!$this->machines->contains($machine)) {
            $this->machines->add($machine);
            $machine->addPoste($this);
        }

        return $this;
    }

    public function removeMachine(Machine $machine): static
    {
        if ($this->machines->removeElement($machine)) {
            $machine->removePoste($this);
        }

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
            $operation->setPoste($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning se to null (unless already changed)
            if ($operation->getPoste() === $this) {
                $operation->setPoste(null);
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
            $realisation->setPosteReel($this);
        }

        return $this;
    }

    public function removeRealisation(Realisation $realisation): static
    {
        if ($this->realisations->removeElement($realisation)) {
            // set the owning se to null (unless already changed)
            if ($realisation->getPosteReel() === $this) {
                $realisation->setPosteReel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Machine>
     */
    public function getMachines2(): Collection
    {
        return $this->machines2;
    }

    public function addMachines2(Machine $machines2): static
    {
        if (!$this->machines2->contains($machines2)) {
            $this->machines2->add($machines2);
            $machines2->addPoste2($this);
        }

        return $this;
    }

    public function removeMachines2(Machine $machines2): static
    {
        if ($this->machines2->removeElement($machines2)) {
            $machines2->removePoste2($this);
        }

        return $this;
    }
}
