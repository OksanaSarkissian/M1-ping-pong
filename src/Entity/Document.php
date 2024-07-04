<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(length: 255)]
    #[Groups(['devis'])]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $montant_total = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $delai = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'documents')]
    private Collection $document;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'document')]
    private Collection $documents;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    /**
     * @var Collection<int, LigneDocument>
     */
    #[ORM\ManyToMany(targetEntity: LigneDocument::class, inversedBy: 'documents')]
    private Collection $ligne_document;

    public function __construct()
    {
        $this->document = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->ligne_document = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montant_total;
    }

    public function setMontantTotal(float $montant_total): static
    {
        $this->montant_total = $montant_total;

        return $this;
    }

    public function getDelai(): ?\DateTimeImmutable
    {
        return $this->delai;
    }

    public function setDelai(?\DateTimeImmutable $delai): static
    {
        $this->delai = $delai;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getDocument(): Collection
    {
        return $this->document;
    }

    public function addDocument(self $document): static
    {
        if (!$this->document->contains($document)) {
            $this->document->add($document);
        }

        return $this;
    }

    public function removeDocument(self $document): static
    {
        $this->document->removeElement($document);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, LigneDocument>
     */
    public function getLigneDocument(): Collection
    {
        return $this->ligne_document;
    }

    public function addLigneDocument(LigneDocument $ligneDocument): static
    {
        if (!$this->ligne_document->contains($ligneDocument)) {
            $this->ligne_document->add($ligneDocument);
        }

        return $this;
    }

    public function removeLigneDocument(LigneDocument $ligneDocument): static
    {
        $this->ligne_document->removeElement($ligneDocument);

        return $this;
    }
}
