<?php

namespace App\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\DBAL\Types\Types;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\LayananRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LayananRepository::class)]
class Layanan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 128)]
    private $name;

    // * @ORM\Column(type="string", length=128, unique=true)
    /**
     * @Gedmo\Slug(fields={"name"})
     */
    #[ORM\Column(type: 'string', length: 128, unique: true)]
    private $slug;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\Column(type: 'decimal', precision: 9, scale: 2, nullable: true)]
    private $price;
    
    /**
    * @var \DateTime
    */
    #[ORM\Column(name: 'created', type: Types::DATE_MUTABLE)]
    #[Gedmo\Timestampable]
    private $created;

    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'updated', nullable: true, type: Types::DATETIMETZ_MUTABLE)]
    #[Gedmo\Timestampable]
    private $updated;

    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'content_changed', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Gedmo\Timestampable(on: 'change', field: ['name', 'description'])]
    private $contentChanged;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $category;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }    

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }   

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = new \DateTime("now");

        return $this;
    }

    public function getContentChanged(): ?\DateTimeInterface
    {
        return $this->contentChanged;
    }

    public function setContentChanged(?\DateTimeInterface $contentChanged): self
    {
        $this->contentChanged = $contentChanged;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

}