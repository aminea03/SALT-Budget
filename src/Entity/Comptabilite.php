<?php

namespace App\Entity;

use App\Repository\ComptabiliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComptabiliteRepository::class)]
class Comptabilite
{

    public function __toString()
    {
        return $this->comptabiliteType;
    }


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $comptabiliteType;

    #[ORM\Column(type: 'smallint')]
    private $coefficientMultiplicateur;

    #[ORM\OneToMany(mappedBy: 'comptabilite', targetEntity: Categories::class, cascade: ["persist", "remove", "merge"], indexBy:('comptabiliteId'))]
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComptabiliteType(): ?string
    {
        return $this->comptabiliteType;
    }

    public function setComptabiliteType(string $comptabiliteType): self
    {
        $this->comptabiliteType = $comptabiliteType;

        return $this;
    }

    public function getCoefficientMultiplicateur(): ?int
    {
        return $this->coefficientMultiplicateur;
    }

    public function setCoefficientMultiplicateur(int $coefficientMultiplicateur): self
    {
        $this->coefficientMultiplicateur = $coefficientMultiplicateur;

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setComptabilite($this);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getComptabilite() === $this) {
                $category->setComptabilite(null);
            }
        }

        return $this;
    }
}
