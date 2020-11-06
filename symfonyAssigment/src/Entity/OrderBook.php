<?php

namespace App\Entity;

use App\Repository\OrderBookRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderBookRepository::class)
 */
class OrderBook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Books::class, inversedBy="orderBooks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orderBooks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userEmail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $processing;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookId(): ?Books
    {
        return $this->bookId;
    }

    public function setBookId(?Books $bookId): self
    {
        $this->bookId = $bookId;

        return $this;
    }

    public function getUserEmail(): ?User
    {
        return $this->userEmail;
    }

    public function setUserEmail(?User $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getProcessing(): ?bool
    {
        return $this->processing;
    }

    public function setProcessing(bool $processing): self
    {
        $this->processing = $processing;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }
}
