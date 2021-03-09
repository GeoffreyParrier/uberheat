<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CircProductConfigurationRepository;
use App\Repository\RectProductConfigurationRepository;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="new-product", methods={"POST"})
     * @param Request $request
     * @param EntityManager $em
     * @return Response
     */
    public function create(Request $request, EntityManager $em): Response
    {
        try {
            $name = $request->get('name');
            if (!$name) {
                throw new BadRequestException('Product name is required');
            }

            $basePrice = $request->get('basePrice');
            if (!$basePrice) {
                throw new BadRequestException('Product base price is required');
            }

            $rect_product_configuration_ids = $request->get('rect_product_configuration_ids');
            $circ_product_configuration_ids = $request->get('circ_product_configuration_ids');
            if (!$rect_product_configuration_ids && !$circ_product_configuration_ids) {
                throw new BadRequestException('A product need at least one configuration');
            }

            $picture = $request->files->get('picture');
            if (!$picture) {
                throw new BadRequestException('Product picture is required');
            }

            $product = new Product();
            $product->setName($name);
            $product->setBasePrice($basePrice);

            $RectProductConfigurations = [];
            if ($rect_product_configuration_ids) {
                foreach ($rect_product_configuration_ids as $index => $rect_product_configuration_id) {
                    $rpcr = new RectProductConfigurationRepository();
                    $rpc = $rpcr->findOneById($rect_product_configuration_id);

                    if (!array_key_exists($rect_product_configuration_id, $RectProductConfigurations)) {
                        array_push($RectProductConfigurations, $rpc);
                    }
                }
            }

            $CircProductConfigurations = [];
            if ($circ_product_configuration_ids) {
                foreach ($circ_product_configuration_ids as $index => $circ_product_configuration_id) {
                    $cpcr = new CircProductConfigurationRepository();
                    $cpc = $cpcr->findOneById($circ_product_configuration_id);

                    if (!array_key_exists($circ_product_configuration_id, $CircProductConfigurations)) {
                        array_push($CircProductConfigurations, $cpc);
                    }
                }
            }

            $productConfigurations = array_merge($RectProductConfigurations, $CircProductConfigurations);
            foreach ($productConfigurations as $productConfiguration) {
                $product->addConfiguration($productConfiguration);
            }

            $em->persist($product);
            $em->flush();
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }


        return $this->json(['code' => 'SUCCESS']);
    }

    /**
     * @Route("/product", name="new-product", methods={"POST"})
     */
    public function read(Request $request): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    // TODO: read all route

    /**
     * @Route("/product", name="new-product", methods={"POST"})
     */
    public function update(Request $request): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/product", name="new-product", methods={"POST"})
     */
    public function delete(Request $request): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
