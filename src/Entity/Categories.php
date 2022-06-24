<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{

    public function __toString()
    {
        return $this->nomCategorie;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nomCategorie;

    #[ORM\ManyToOne(targetEntity: comptabilite::class, inversedBy: 'categories')]
    #[ORM\JoinColumn(nullable: false)]
    private $comptabilite;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Transactions::class)]
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    public function getComptabilite(): ?comptabilite
    {
        return $this->comptabilite;
    }

    public function setComptabilite(?comptabilite $comptabilite): self
    {
        $this->comptabilite = $comptabilite;

        return $this;
    }

    /**
     * @return Collection<int, Transactions>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transactions $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCategorie($this);
        }

        return $this;
    }

    public function removeTransaction(Transactions $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCategorie() === $this) {
                $transaction->setCategorie(null);
            }
        }

        return $this;
    }
}
