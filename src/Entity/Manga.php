<?php

namespace App\Entity;

use App\Repository\MangaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MangaRepository::class)]
class Manga extends Book
{
    #[ORM\ManyToOne(inversedBy: 'mangas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Serie $serie = null;

    #[ORM\Column]
    private ?int $volume_number = null;

    #[ORM\OneToOne(mappedBy: 'manga', cascade: ['persist', 'remove'])]
    private ?Stock $stock = null;

    #[ORM\OneToMany(mappedBy: 'manga', targetEntity: Borrowing::class, orphanRemoval: true)]
    private Collection $borrowings;

    #[ORM\OneToMany(mappedBy: 'manga', targetEntity: Purchase::class, orphanRemoval: true)]
    private Collection $purchases;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    public function __construct()
    {
        $this->borrowings = new ArrayCollection();
        $this->purchases = new ArrayCollection();
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getVolumeNumber(): ?int
    {
        return $this->volume_number;
    }

    public function setVolumeNumber(int $volume_number): self
    {
        $this->volume_number = $volume_number;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): self
    {
        // set the owning side of the relation if necessary
        if ($stock->getManga() !== $this) {
            $stock->setManga($this);
        }

        $this->stock = $stock;

        return $this;
    }

    /**
     * @return ArrayCollection<int, Borrowing>
     */
    public function getBorrowings(): ArrayCollection
    {
        return $this->borrowings;
    }

    public function addBorrowing(Borrowing $borrowing): self
    {
        if (!$this->borrowings->contains($borrowing)) {
            $this->borrowings->add($borrowing);
            $borrowing->setManga($this);
        }

        return $this;
    }

    public function removeBorrowing(Borrowing $borrowing): self
    {
        if ($this->borrowings->removeElement($borrowing)) {
            // set the owning side to null (unless already changed)
            if ($borrowing->getManga() === $this) {
                $borrowing->setManga(null);
            }
        }

        return $this;
    }

    /**
     * @return ArrayCollection<int, Purchase>
     */
    public function getPurchases(): ArrayCollection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases->add($purchase);
            $purchase->setManga($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getManga() === $this) {
                $purchase->setManga(null);
            }
        }

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }
}
