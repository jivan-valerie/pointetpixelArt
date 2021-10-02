<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $info;

    /**
     * @ORM\OneToMany(targetEntity=Tableaux::class, mappedBy="category")
     */
    private $tableaux;

    // /**
    //  * @ORM\OneToMany(targetEntity=Artnumerique::class, mappedBy="category", orphanRemoval=true)
    //  */
    // private $artnumeriques;

    public function __construct()
    {
        $this->tableaux = new ArrayCollection();
        // $this->artnumeriques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): self
    {
        $this->info = $info;

        return $this;
    }

    /**
     * @return Collection|Tableaux[]
     */
    public function getTableaux(): Collection
    {
        return $this->tableaux;
    }

    public function addTableaux(Tableaux $tableaux): self
    {
        if (!$this->tableaux->contains($tableaux)) {
            $this->tableaux[] = $tableaux;
            $tableaux->setCategory($this);
        }

        return $this;
    }

    public function removeTableaux(Tableaux $tableaux): self
    {
        if ($this->tableaux->removeElement($tableaux)) {
            // set the owning side to null (unless already changed)
            if ($tableaux->getCategory() === $this) {
                $tableaux->setCategory(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection|Artnumerique[]
    //  */
    // public function getArtnumeriques(): Collection
    // {
    //     return $this->artnumeriques;
    // }

    // public function addArtnumerique(Artnumerique $artnumerique): self
    // {
    //     if (!$this->artnumeriques->contains($artnumerique)) {
    //         $this->artnumeriques[] = $artnumerique;
    //         $artnumerique->setCategory($this);
    //     }

    //     return $this;
    // }

    // public function removeArtnumerique(Artnumerique $artnumerique): self
    // {
    //     if ($this->artnumeriques->removeElement($artnumerique)) {
    //         // set the owning side to null (unless already changed)
    //         if ($artnumerique->getCategory() === $this) {
    //             $artnumerique->setCategory(null);
    //         }
    //     }

    //     return $this;
    // }
}
