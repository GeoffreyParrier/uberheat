<?php

namespace App\ProductConfiguration\Builder;

use App\Entity\CircProductConfiguration;
use App\Entity\ProductConfiguration;

class CircularBuilder extends AbstractBuilder
{
  /** @var CircProductConfiguration */
  protected $productState;

    /**
     * @param array $data
     * @return CircProductConfiguration
     */
    public function stepSpecificAttributes(array $data): CircProductConfiguration
  {
    $this->productState->setDiameter(intval($data[6]));
  }

    /**
     * Set product state to new empty CircProductConfiguration object
     */
    public function reset(): void
  {
    $this->productState = new CircProductConfiguration();
  }
}
