<?php

namespace App\Entity;

use App\Repository\TechniqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TechniqueRepository::class)
 */
class Technique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Tableaux::class, mappedBy="technique", orphanRemoval=true)
     */
    private $technique_tableaux;

    public function __construct()
    {
        $this->technique_tableaux = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Tableaux[]
     */
    public function getTechniqueTableaux(): Collection
    {
        return $this->technique_tableaux;
    }

    public function addTechniqueTableaux(Tableaux $techniqueTableaux): self
    {
        if (!$this->technique_tableaux->contains($techniqueTableaux)) {
            $this->technique_tableaux[] = $techniqueTableaux;
            $techniqueTableaux->setTechnique($this);
        }

        return $this;
    }

    public function removeTechniqueTableaux(Tableaux $techniqueTableaux): self
    {
        if ($this->technique_tableaux->removeElement($techniqueTableaux)) {
            // set the owning side to null (unless already changed)
            if ($techniqueTableaux->getTechnique() === $this) {
                $techniqueTableaux->setTechnique(null);
            }
        }

        return $this;
    }

    
}
