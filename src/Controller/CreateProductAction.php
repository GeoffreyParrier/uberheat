<?php


namespace App\Controller;

use App\Entity\MediaObject;
use App\Entity\Product;
use App\Repository\CircProductConfigurationRepository;
use App\Repository\RectProductConfigurationRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

final class CreateProductAction
{
    public function __invoke(Request $request, RectProductConfigurationRepository $rectProductConfigurationRepository, CircProductConfigurationRepository $circProductConfigurationRepository): Product
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

//        $configurations_ids = explode(', ', $request->get('configurations_ids'));
//        if (!$configurations_ids) {
//            throw new BadRequestException('Product configurations_ids is required');
//        }

        $rect_product_configuration_ids = $request->get('rect_product_configuration_ids');
        if ($rect_product_configuration_ids) {
            $rect_product_configuration_ids = explode(', ', $request->get('rect_product_configuration_ids'));
        }
        $circ_product_configuration_ids = $request->get('circ_product_configuration_ids');
        if ($circ_product_configuration_ids) {
            $circ_product_configuration_ids = explode(', ', $request->get('circ_product_configuration_ids'));
        }

        if (!$rect_product_configuration_ids && !$circ_product_configuration_ids) {
            throw new BadRequestException('A product need at least one configuration');
        }

        $rectProductConfigurations = [];
        if ($rect_product_configuration_ids) {
            foreach ($rect_product_configuration_ids as $index => $rect_product_configuration_id) {
                $rectProductConfiguration = $rectProductConfigurationRepository->findOneById($rect_product_configuration_id);

                if (!array_key_exists($rect_product_configuration_id, $rectProductConfigurations)) {
                    array_push($rectProductConfigurations, $rectProductConfiguration);
                }
            }
        }

        $circProductConfigurations = [];
        if ($circ_product_configuration_ids) {
            foreach ($circ_product_configuration_ids as $index => $circ_product_configuration_id) {
                $circProductConfiguration = $circProductConfigurationRepository->findOneById($circ_product_configuration_id);

                if (!array_key_exists($circ_product_configuration_id, $circProductConfigurations)) {
                    array_push($circProductConfigurations, $circProductConfiguration);
                }
            }
        }


        $mediaObject = new MediaObject();
        $mediaObject->file = $picture;

        $product = new Product();
        $product->setName($name)
            ->setBasePrice($basePrice)
            ->setProductImg($mediaObject);

        $productConfigurations = array_merge($rectProductConfigurations, $circProductConfigurations);
        foreach ($productConfigurations as $productConfiguration) {
            $product->addConfiguration($productConfiguration);
        }


//        foreach ($configurations_ids as $configuration_id) {
//            $configurationObj = $productConfigurationRepository->find($configuration_id);
//            $product->addConfiguration($configurationObj);
//        }

        return $product;
    }
}
