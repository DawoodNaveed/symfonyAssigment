<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=BooksRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(
 *     fields={"isbn"},
 *     message="This isbn have already registered!"
 * )
 */
class Books
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
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="string",unique=true, length=100, nullable=true)
     */
    private $isbn;


    /**
     * @ORM\Column (type="string",length=100)
     */

    private $image;


    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="image")
     */
    private $imageFile;

    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedDate;

    /**
     * @ORM\OneToMany(targetEntity=OrderBook::class, mappedBy="bookId",cascade={"persist", "remove"})
     */
    private $orderBooks;



    public function __construct()
    {
        $this->updatedAt=new \DateTime();
        $this->orderBooks = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     */
    public function setImageFile($imageFile): void
    {
        $this->imageFile = $imageFile;
        if($imageFile) {
            $this->updatedAt=new \DateTime();
        }
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }


    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getPublishedDate(): ?string
    {
        if($this->publishedDate!=NULL)
        {
            return $this->publishedDate->format('Y-m-d');
        } else{
            return $this->publishedDate;
        }
    }

    public function setPublishedDate(?\DateTimeInterface $publishedDate): self
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * @return Collection|OrderBook[]
     */
    public function getOrderBooks(): Collection
    {
        return $this->orderBooks;
    }

    public function addOrderBook(OrderBook $orderBook): self
    {
        if (!$this->orderBooks->contains($orderBook)) {
            $this->orderBooks[] = $orderBook;
            $orderBook->setBookId($this);
        }

        return $this;
    }

    public function removeOrderBook(OrderBook $orderBook): self
    {
        if ($this->orderBooks->contains($orderBook)) {
            $this->orderBooks->removeElement($orderBook);
            // set the owning side to null (unless already changed)
            if ($orderBook->getBookId() === $this) {
                $orderBook->setBookId(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name;

    }


}
