<?php

namespace App\Entity;

use App\Repository\TableauxRepository;
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
     * @ORM\Column(type="float", nullable=true)
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
     * @ORM\Column(type="float")
     */
    private $tva;



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
    
    public function CalculPrix($longueur,$largeur,$tva){
            $prix=0;
            $nb= $longueur + $largeur;
                switch ($nb) {
                    case $nb <28:
                        $prix=0;
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
                    default:
                        $prix = 4000;
                    break;
                    }
        return $prix + ($prix*$tva/100);
        // $prixUnit = $longueur + $largeur;
            // if($prixUnit > 25 && $prixUnit <40) {$prix = 8000;
            //     return $prix + ($prix*$tva/100);}
        
            

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
    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }
    
}

