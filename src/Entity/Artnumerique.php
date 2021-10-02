<?php

namespace App\Entity;

use App\Repository\ArtnumeriqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtnumeriqueRepository::class)
 */
class Artnumerique
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
     * @ORM\Column(type="text")
     */
    private $description;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $image;

    // // /**
    // //  * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="artnumeriques")
    // //  * @ORM\JoinColumn(nullable=false)
    // //  */
    // private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $iframe;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="artnumeriques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    // public function getCategory(): ?Category
    // {
    //     return $this->category;
    // }

    // public function setCategory(?Category $category): self
    // {
    //     $this->category = $category;

    //     return $this;
    // }

    public function getIframe(): ?string
    {
        return $this->iframe;
    }

    public function setIframe(string $iframe): self
    {
        $this->iframe = $iframe;

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
}
