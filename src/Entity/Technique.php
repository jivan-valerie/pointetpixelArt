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
    private $Tableaux;

    public function __construct()
    {
        $this->Tableaux = new ArrayCollection();
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
    public function getTableaux(): Collection
    {
        return $this->Tableaux;
    }

    public function addTableaux(Tableaux $tableaux): self
    {
        if (!$this->Tableaux->contains($tableaux)) {
            $this->Tableaux[] = $tableaux;
            $tableaux->setTechnique($this);
        }

        return $this;
    }

    public function removeTableaux(Tableaux $tableaux): self
    {
        if ($this->Tableaux->removeElement($tableaux)) {
            // set the owning side to null (unless already changed)
            if ($tableaux->getTechnique() === $this) {
                $tableaux->setTechnique(null);
            }
        }

        return $this;
    }
}
