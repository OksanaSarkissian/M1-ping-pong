<?php

namespace App\Entity;

use App\Repository\RealisationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RealisationRepository::class)]
class Realisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $temps_reel = null;

    #[ORM\ManyToOne(inversedBy: 'realisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Poste $poste_reel = null;

    #[ORM\ManyToOne(inversedBy: 'realisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Machine $machine_reel = null;

    #[ORM\ManyToOne(inversedBy: 'realisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Piece $piece = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTempsReel(): ?\DateTimeInterface
    {
        return $this->temps_reel;
    }

    public function setTempsReel(\DateTimeInterface $temps_reel): static
    {
        $this->temps_reel = $temps_reel;

        return $this;
    }

    public function getPosteReel(): ?Poste
    {
        return $this->poste_reel;
    }

    public function setPosteReel(?Poste $poste_reel): static
    {
        $this->poste_reel = $poste_reel;

        return $this;
    }

    public function getMachineReel(): ?Machine
    {
        return $this->machine_reel;
    }

    public function setMachineReel(?Machine $machine_reel): static
    {
        $this->machine_reel = $machine_reel;

        return $this;
    }

    public function getPiece(): ?Piece
    {
        return $this->piece;
    }

    public function setPiece(?Piece $piece): static
    {
        $this->piece = $piece;

        return $this;
    }
}
