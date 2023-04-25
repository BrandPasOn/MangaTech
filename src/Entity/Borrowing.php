<?php

namespace App\Entity;

use App\Repository\BorrowingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BorrowingRepository::class)]
class Borrowing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'borrowings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'borrowings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Manga $manga = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $borrowing_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $return_date = null;

    #[ORM\Column]
    private ?bool $is_returned = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getManga(): ?Manga
    {
        return $this->manga;
    }

    public function setManga(?Manga $manga): self
    {
        $this->manga = $manga;

        return $this;
    }

    public function getBorrowingDate(): ?\DateTimeInterface
    {
        return $this->borrowing_date;
    }

    public function setBorrowingDate(\DateTimeInterface $borrowing_date): self
    {
        $this->borrowing_date = $borrowing_date;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->return_date;
    }

    public function setReturnDate(\DateTimeInterface $return_date): self
    {
        $this->return_date = $return_date;

        return $this;
    }

    public function isIsReturned(): ?bool
    {
        return $this->is_returned;
    }

    public function setIsReturned(bool $is_returned): self
    {
        $this->is_returned = $is_returned;

        return $this;
    }
}
