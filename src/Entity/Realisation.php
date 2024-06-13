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
    private ?Poste $poste_id_reel = null;

    #[ORM\ManyToOne(inversedBy: 'realisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Machine $machine_id_reel = null;

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

    public function getPosteIdReel(): ?Poste
    {
        return $this->poste_id_reel;
    }

    public function setPosteIdReel(?Poste $poste_id_reel): static
    {
        $this->poste_id_reel = $poste_id_reel;

        return $this;
    }

    public function getMachineIdReel(): ?Machine
    {
        return $this->machine_id_reel;
    }

    public function setMachineIdReel(?Machine $machine_id_reel): static
    {
        $this->machine_id_reel = $machine_id_reel;

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
