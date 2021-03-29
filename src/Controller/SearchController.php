<?php

namespace App\Controller;

use App\Repository\ProductConfigurationRepository;
use App\Search\GetProductConfigurationsSearchResultConcreteStrategy;
use App\Search\SaveProductConfigurationSearchResultConcreteStrategy;
use App\Search\SearchContext;
use App\Search\SearchIntent;
use App\Search\SearchStrategy;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search", methods={"POST"})
     * @param Request $request
     * @param SearchContext $searchContext
     * @param ProductConfigurationRepository $productConfigurationRepository
     * @return JsonResponse
     */
    public function searchAction(Request $request, SearchContext $searchContext, ProductConfigurationRepository $productConfigurationRepository): JsonResponse
    {
        $query = $request->getContent();

        return $this->searchActionsLogic($productConfigurationRepository, $query, $searchContext);
    }

    /**
     * @Route("/search/save", name="search-save", methods={"POST"})
     * @param Request $request
     * @param SearchContext $searchContext
     * @param ProductConfigurationRepository $productConfigurationRepository
     * @return JsonResponse
     */
    public function saveSearchAction(Request $request, SearchContext $searchContext, ProductConfigurationRepository $productConfigurationRepository): JsonResponse
    {
        $query = $request->getContent();
        return $this->searchActionsLogic($productConfigurationRepository, $query, $searchContext);
    }

    /**
     * Get correct ConcreteSearchStrategy instance
     *
     * @param ProductConfigurationRepository $productConfigurationRepository
     * @param String $searchType Search Type as string
     * @return SearchStrategy The instance
     * @throws Exception if search type doesn't match with a strategy
     */
    private function getSearchConcreteStrategyInstance(ProductConfigurationRepository $productConfigurationRepository, string $searchType): SearchStrategy
    {
        $concreteStrategy = null;

        /** @noinspection PhpSwitchCanBeReplacedWithMatchExpressionInspection */
        switch ($searchType) {
            case GetProductConfigurationsSearchResultConcreteStrategy::getType():
                $concreteStrategy = new GetProductConfigurationsSearchResultConcreteStrategy($productConfigurationRepository);
                break;

            case SaveProductConfigurationSearchResultConcreteStrategy::getType():
                $concreteStrategy = new SaveProductConfigurationSearchResultConcreteStrategy();
                break;

            default:
                throw new Exception('Unknown search type.');
        }

        return $concreteStrategy;
    }

    /**
     * Search Actions logic
     *
     * @param ProductConfigurationRepository $productConfigurationRepository
     * @param String $query Extracted query string
     * @param SearchContext $searchContext SearchContext DependencyInjection
     * @return JsonResponse The action return
     */
    private function searchActionsLogic(ProductConfigurationRepository $productConfigurationRepository, string $query, SearchContext $searchContext): JsonResponse
    {
        try {
            $searchIntent = new SearchIntent();
            $searchIntent->setSearch(json_decode($query));

            $searchConcreteStrategy = $this->getSearchConcreteStrategyInstance($productConfigurationRepository, $searchIntent->getSearchType());

            $searchContext->setStrategy($searchConcreteStrategy);

            $searchResult = $searchContext->execute($searchIntent);
    
            return $this->json([
                'error' => null,
                'data' => $searchResult
            ]);
        } catch (Exception $e) {
            return $this->json([
                'error' => [
                    'code' => 'HTTP_BAD_REQUEST',
                    'message' => $e->getMessage()
                ],
                'data' => null
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
