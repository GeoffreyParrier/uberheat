<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RectProductConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RectProductConfigurationRepository::class)
 */
class RectProductConfiguration extends ProductConfiguration
{
    /**
     * @ORM\Column(type="integer")
     */
    private int $width;

    /**
     * @ORM\Column(type="integer")
     */
    private int $height;

    /**
     * @ORM\Column(type="integer")
     */
    private int $thickness;

    public function getSurface(): int
    {
        return $this->width * $this->height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return $this
     */
    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return $this
     */
    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int
     */
    public function getThickness(): int
    {
        return $this->thickness;
    }

    /**
     * @param int $thickness
     * @return $this
     */
    public function setThickness(int $thickness): self
    {
        $this->thickness = $thickness;

        return $this;
    }
}
