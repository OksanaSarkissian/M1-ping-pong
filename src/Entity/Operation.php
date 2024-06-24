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
    private ?Poste $poste_id = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Machine $machine_id = null;

    /**
     * @var Collection<int, Gamme>
     */
    #[ORM\ManyToMany(targetEntity: Gamme::class, mappedBy: 'operations')]
    private Collection $gammes;

    public function __construct()
    {
        $this->gammes = new ArrayCollection();
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

    public function getPosteId(): ?Poste
    {
        return $this->poste_id;
    }

    public function setPosteId(?Poste $poste_id): static
    {
        $this->poste_id = $poste_id;

        return $this;
    }

    public function getMachineId(): ?Machine
    {
        return $this->machine_id;
    }

    public function setMachineId(?Machine $machine_id): static
    {
        $this->machine_id = $machine_id;

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
}
