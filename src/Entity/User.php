<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Tableaux::class, mappedBy="User", orphanRemoval=true)
     */
    private $tableauxuser;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="user", orphanRemoval=true)
     */
    private $commandes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    // /**
    //  * @ORM\Column(type="string", length=255, nullable=true)
    //  */
    // private $complement_adresse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $banni=false;

    /**
     * @ORM\OneToMany(targetEntity=Artnumerique::class, mappedBy="User", orphanRemoval=true)
     */
    private $artnumeriques;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="user", orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\Column(type="integer")
     */
    private $code_posta;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ville;

    public function __construct()
    {
        $this->tableauxuser = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->artnumeriques = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Tableaux[]
     */
    public function getTableauxuser(): Collection
    {
        return $this->tableauxuser;
    }

    public function addTableauxuser(Tableaux $tableauxuser): self
    {
        if (!$this->tableauxuser->contains($tableauxuser)) {
            $this->tableauxuser[] = $tableauxuser;
            $tableauxuser->setUser($this);
        }

        return $this;
    }

    public function removeTableauxuser(Tableaux $tableauxuser): self
    {
        if ($this->tableauxuser->removeElement($tableauxuser)) {
            // set the owning side to null (unless already changed)
            if ($tableauxuser->getUser() === $this) {
                $tableauxuser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    // public function getComplementAdresse(): ?string
    // {
    //     return $this->complement_adresse;
    // }

    // public function setComplementAdresse(string $complement_adresse): self
    // {
    //     $this->complement_adresse = $complement_adresse;

    //     return $this;
    // }

    public function getBanni(): ?bool
    {
        return $this->banni;
    }

    public function setBanni(bool $banni): self
    {
        $this->banni = $banni;

        return $this;
    }

    /**
     * @return Collection|Artnumerique[]
     */
    public function getArtnumeriques(): Collection
    {
        return $this->artnumeriques;
    }

    public function addArtnumerique(Artnumerique $artnumerique): self
    {
        if (!$this->artnumeriques->contains($artnumerique)) {
            $this->artnumeriques[] = $artnumerique;
            $artnumerique->setUser($this);
        }

        return $this;
    }

    public function removeArtnumerique(Artnumerique $artnumerique): self
    {
        if ($this->artnumeriques->removeElement($artnumerique)) {
            // set the owning side to null (unless already changed)
            if ($artnumerique->getUser() === $this) {
                $artnumerique->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setUser($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getUser() === $this) {
                $image->setUser(null);
            }
        }

        return $this;
    }

    public function getCodePosta(): ?int
    {
        return $this->code_posta;
    }

    public function setCodePosta(int $code_posta): self
    {
        $this->code_posta = $code_posta;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }
}
