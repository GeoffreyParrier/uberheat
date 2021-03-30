<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProductConfigurationRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *   "rect" = "RectProductConfiguration",
 *   "circ" = "CircProductConfiguration"
 * })
 */
abstract class ProductConfiguration
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  protected int $id;

  /**
   * @ORM\Column(type="integer")
   */
  protected int $depth;

  /**
   * @ORM\Column(type="float")
   */
  protected float $dB1;

  /**
   * @ORM\Column(type="float")
   */
  protected float $dB2;

  /**
   * @ORM\Column(type="float")
   */
  protected float $dB5;

  /**
   * @ORM\Column(type="float")
   */
  protected float $dB10;

  /**
   * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="configurations")
   * @ORM\JoinColumn(nullable=false)
   */
  protected Product $product;

    /**
     * @return int
     */
    public function getId(): int
  {
    return $this->id;
  }

    /**
     * @return int
     */
    public function getDepth(): int
  {
    return $this->depth;
  }

    /**
     * @param int $depth
     * @return $this
     */
    public function setDepth(int $depth): self
  {
    $this->depth = $depth;

    return $this;
  }

    /**
     * @return float
     */
    public function getDB1(): float
  {
    return $this->dB1;
  }

    /**
     * @param float $dB1
     * @return $this
     */
    public function setDB1(float $dB1): self
  {
    $this->dB1 = $dB1;

    return $this;
  }

    /**
     * @return float
     */
    public function getDB2(): float
  {
    return $this->dB2;
  }

    /**
     * @param float $dB2
     * @return $this
     */
    public function setDB2(float $dB2): self
  {
    $this->dB2 = $dB2;

    return $this;
  }

    /**
     * @return float
     */
    public function getDB5(): float
  {
    return $this->dB5;
  }

    /**
     * @param float $dB5
     * @return $this
     */
    public function setDB5(float $dB5): self
  {
    $this->dB5 = $dB5;

    return $this;
  }

    /**
     * @return float
     */
    public function getDB10(): float
  {
    return $this->dB10;
  }

    /**
     * @param float $dB10
     * @return $this
     */
    public function setDB10(float $dB10): self
  {
    $this->dB10 = $dB10;

    return $this;
  }

    /**
     * @return Product
     */
    public function getProduct(): Product
  {
    return $this->product;
  }

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct(Product $product): self
  {
    $this->product = $product;

    return $this;
  }

    /**
     * @return mixed
     */
    public abstract function getSurface();
}
