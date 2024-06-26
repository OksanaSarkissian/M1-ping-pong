<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $identifiant = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

      /**
     * @var list<string> The user roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var Collection<int, Poste>
     */
    #[ORM\ManyToMany(targetEntity: Poste::class, inversedBy: 'id_user')]
    private Collection $qualifications;

    /**
     * @var Collection<int, Gamme>
     */
    #[ORM\OneToMany(mappedBy: 'responsable', targetEntity: Gamme::class)]
    private Collection $gammes;

    public function __construct()
    {
        $this->qualifications = new ArrayCollection();
        $this->gammes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): static
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->identifiant;
    }
 
    public function setRoles($roles): static
    {
        $this->roles = $roles;
 
        return $this;
    }
    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
 
        return array_unique($roles);
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Poste>
     */
    public function getQualifications(): Collection
    {
        return $this->qualifications;
    }

    public function addPoste(Poste $poste): static
    {
        if (!$this->qualifications->contains($poste)) {
            $this->qualifications->add($poste);
            $poste->addIdUser($this);
        }

        return $this;
    }

    public function removePoste(Poste $poste): static
    {
        if ($this->qualifications->removeElement($poste)) {
            $poste->removeIdUser($this);
        }

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
            $gamme->setResponsable($this);
        }

        return $this;
    }

    public function removeGamme(Gamme $gamme): static
    {
        if ($this->gammes->removeElement($gamme)) {
            // set the owning side to null (unless already changed)
            if ($gamme->getResponsable() === $this) {
                $gamme->setResponsable(null);
            }
        }

        return $this;
    }

    public function getFullName()
    {
        return $this->getPrenom() . ' ' . $this->getNom(); 
    }
}
