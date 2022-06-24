<?php

namespace App\Entity;

use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionsRepository::class)]
class Transactions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $montantTransaction;

    #[ORM\Column(type: 'date')]
    private $dateTransaction;

    #[ORM\ManyToOne(targetEntity: Categories::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private $categorie;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: paiements::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private $paiement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantTransaction(): ?int
    {
        return $this->montantTransaction;
    }

    public function setMontantTransaction(int $montantTransaction): self
    {
        $this->montantTransaction = $montantTransaction;

        return $this;
    }

    public function getDateTransaction(): ?\DateTimeInterface
    {
        return $this->dateTransaction;
    }

    public function setDateTransaction(\DateTimeInterface $dateTransaction): self
    {
        $this->dateTransaction = $dateTransaction;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPaiement(): ?paiements
    {
        return $this->paiement;
    }

    public function setPaiement(?paiements $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }
}
