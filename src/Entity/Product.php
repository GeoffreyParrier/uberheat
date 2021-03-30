<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use App\Controller\CreateProductAction;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "post"={
 *             "controller"=CreateProductAction::class,
 *             "deserialize"=false,
 *         },
 *         "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $basePrice;

    /**
     * @ORM\OneToMany(targetEntity=ProductConfiguration::class, mappedBy="product", orphanRemoval=true)
     */
    private Collection $configurations;

    /**
     * @ORM\OneToOne(targetEntity=MediaObject::class, cascade={"persist", "remove"})
     */
    private MediaObject $productImg;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->configurations = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getBasePrice(): ?float
    {
        return $this->basePrice;
    }

    /**
     * @param float $basePrice
     * @return $this
     */
    public function setBasePrice(float $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getConfigurations(): Collection
    {
        return $this->configurations;
    }

    /**
     * @param ProductConfiguration $configuration
     * @return $this
     */
    public function addConfiguration(ProductConfiguration $configuration): self
    {
        if (!$this->configurations->contains($configuration)) {
            $this->configurations[] = $configuration;
            $configuration->setProduct($this);
        }

        return $this;
    }

    /**
     * @param ProductConfiguration $configuration
     * @return $this
     */
    public function removeConfiguration(ProductConfiguration $configuration): self
    {
        if ($this->configurations->removeElement($configuration)) {
            // set the owning side to null (unless already changed)
            if ($configuration->getProduct() === $this) {
                $configuration->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return MediaObject
     */
    public function getProductImg(): MediaObject
    {
        return $this->productImg;
    }

    /**
     * @param MediaObject $productImg
     * @return $this
     */
    public function setProductImg(MediaObject $productImg): self
    {
        $this->productImg = $productImg;

        return $this;
    }
}
