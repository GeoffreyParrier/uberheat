<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CircProductConfigurationRepository;
use App\Repository\RectProductConfigurationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * This route is deprecated because it doesn't support image. Please use Api Plateforme route
     *
     * @Route("/products", name="new-product", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param RectProductConfigurationRepository $rectProductConfigurationRepository
     * @param CircProductConfigurationRepository $circProductConfigurationRepository
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $em, RectProductConfigurationRepository $rectProductConfigurationRepository, CircProductConfigurationRepository $circProductConfigurationRepository): Response
    {
        try {
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


            $picture = $request->files->get('picture');
            if (!$picture) {
                throw new BadRequestException('Product picture is required');
            }

            $product = new Product();
            $product->setName($request->get('name'));
            $product->setBasePrice($request->get('basePrice'));

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

            $productConfigurations = array_merge($rectProductConfigurations, $circProductConfigurations);
            foreach ($productConfigurations as $productConfiguration) {
                $product->addConfiguration($productConfiguration);
            }

            $em->persist($product);
            $em->flush();
        } catch (Exception $e) {
            return $this->json([
                'error' => [
                    'code' => 'Bad Request',
                    'message' => $e->getMessage(),
                ],
                'data' => null
            ], Response::HTTP_BAD_REQUEST);
        }


        return $this->json([], Response::HTTP_NO_CONTENT);
    }

//    /**
//     * @Route("/product", name="new-product", methods={"POST"})
//     */
//    public function read(Request $request): Response
//    {
//        return $this->render('product/index.html.twig', [
//            'controller_name' => 'ProductController',
//        ]);
//    }
//
//    // TODO: read all route
//
//    /**
//     * @Route("/product", name="new-product", methods={"POST"})
//     */
//    public function update(Request $request): Response
//    {
//        return $this->render('product/index.html.twig', [
//            'controller_name' => 'ProductController',
//        ]);
//    }
//
//    /**
//     * @Route("/product", name="new-product", methods={"POST"})
//     */
//    public function delete(Request $request): Response
//    {
//        return $this->render('product/index.html.twig', [
//            'controller_name' => 'ProductController',
//        ]);
//    }
}
