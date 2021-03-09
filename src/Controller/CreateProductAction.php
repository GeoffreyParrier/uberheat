<?php


namespace App\Controller;

use App\Entity\MediaObject;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

final class CreateProductAction
{
    public function __invoke(Request $request): Product
    {
        $name = $request->get('name');
        if (!$name) {
            throw new BadRequestException('Product name is required');
        }

        $basePrice = $request->get('basePrice');
        if (!$basePrice && $basePrice < '0') {
            throw new BadRequestException('Product base price is required: ' . $basePrice);
        }

        $picture = $request->files->get('picture');
        if (!$picture) {
            throw new BadRequestException('Product picture is required');
        }

        $mediaObject = new MediaObject();
        $mediaObject->file = $picture;

        $product = new Product();
        $product->setName($name)
            ->setBasePrice($basePrice)
            ->setProductImg($mediaObject);

        return $product;
    }
}
