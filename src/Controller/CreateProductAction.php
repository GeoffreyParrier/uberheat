<?php


namespace App\Controller;

use App\Entity\MediaObject;
use App\Entity\Product;
use App\Repository\ProductConfigurationRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

final class CreateProductAction
{
    public function __invoke(Request $request, ProductConfigurationRepository $productConfigurationRepository): Product
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

        $configurations_ids = explode(', ', $request->get('configurations_ids'));
        if (!$configurations_ids) {
            throw new BadRequestException('Product configurations_ids is required');
        }

        $mediaObject = new MediaObject();
        $mediaObject->file = $picture;

        $product = new Product();
        $product->setName($name)
            ->setBasePrice($basePrice)
            ->setProductImg($mediaObject);

        foreach ($configurations_ids as $configuration_id) {
            $configurationObj = $productConfigurationRepository->find($configuration_id);
            $product->addConfiguration($configurationObj);
        }

        return $product;
    }
}
