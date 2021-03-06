<?php

namespace App\Entity;

use App\Repository\TableauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TableauxRepository::class)
 */
class Tableaux
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $auteur;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $image;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, nullable=true)
     */

    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="tableaux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="float")
     */
    private $longueur;

    /**
     * @ORM\Column(type="float")
     */
    private $largeur;

    

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tableauxuser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="boolean")
     */
    private $vendu=false;

    /**
     * @ORM\ManyToOne(targetEntity=Technique::class, inversedBy="technique_tableaux")
     * @ORM\JoinColumn(nullable=false)
     */
    
    private $technique;

    /**
     * @ORM\Column(type="float")
     */
    private $tva;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="tableaux")
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        
        $this->prix = $prix;

        return $this;
    }
    // m??thode avec 3 param??tres
    public function CalculPrix($longueur,$largeur,$tva){
            $prix=0;
       // prix conseill?? calcul?? en fonction des dimensions du tableau     
            $nb= $longueur + $largeur;
                switch ($nb) {
                    case $nb <28:
                        $prix=10;
                        break;
                    case $nb >28 && $nb<=38:
                        $prix=20;
                        break;
                    case $nb >38 && $nb<=43:
                        $prix=40;
                        break;
                    case $nb >43 && $nb<=49:
                        $prix=60;
                        break;
                    case $nb >49 && $nb<=57:
                        $prix=80;
                        break;
                    case $nb >57 && $nb<=64;
                        $prix=100;
                    case $nb >64 && $nb<=72;
                        $prix=120;
                    default:
                        $prix = 400;
                    break;
                    }
                    $prix= $prix + ($prix *$tva/100);
        return $prix ;
        

    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getLargeur(): ?float
    {
        return $this->largeur;
    }

    public function setLargeur(float $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }
    

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getVendu(): ?bool
    {
        return $this->vendu;
    }

    public function setVendu(bool $vendu): self
    {
        $this->vendu = $vendu;

        return $this;
    }

    public function getTechnique(): ?Technique
    {
        return $this->technique;
    }

    public function setTechnique(?Technique $technique): self
    {
        $this->technique = $technique;

        return $this;
    }

   

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

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
            $commande->setTableaux($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getTableaux() === $this) {
                $commande->setTableaux(null);
            }
        }

        return $this;
    }

   
   

    
   
   

    
    
}

