<?php

namespace App\Controller;

use App\Entity\SearchIntent;
use App\Repository\ProductConfigurationRepository;
use App\Search\GetProductConfigurationsSearchResultConcreteStrategy;
use App\Search\SearchContext;
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

        return $this->searchActionsLogic($query, $searchContext, $productConfigurationRepository);
    }

    /**
     * @Route("/search/save", name="search-save", methods={"POST"})
     * @param Request $request
     * @param SearchContext $searchContext
     * @return JsonResponse
     */
    public function saveSearchAction(Request $request, SearchContext $searchContext): JsonResponse
    {
        $query = $request->getContent();
        return $this->searchActionsLogic($query, $searchContext);
    }

    /**
     * Get correct ConcreteSearchStrategy instance
     *
     * @param String $searchType Search Type as string
     * @param ProductConfigurationRepository|null $productConfigurationRepository
     * @return SearchStrategy The instance
     * @throws Exception if search type doesn't match with a strategy
     */
    private function getSearchConcreteStrategyInstance(string $searchType, ProductConfigurationRepository $productConfigurationRepository = null): SearchStrategy
    {
        $concreteStrategy = null;

        /** @noinspection PhpSwitchCanBeReplacedWithMatchExpressionInspection */
        switch ($searchType) {
            case GetProductConfigurationsSearchResultConcreteStrategy::getType():
                $concreteStrategy = new GetProductConfigurationsSearchResultConcreteStrategy($productConfigurationRepository);
                break;

            default:
                throw new Exception('Unknown search type.');
        }

        return $concreteStrategy;
    }

    /**
     * Search Actions logic
     *
     * @param String $query Extracted query string
     * @param SearchContext $searchContext SearchContext DependencyInjection
     * @param ProductConfigurationRepository|null $productConfigurationRepository
     * @return JsonResponse The action return
     */
    private function searchActionsLogic(string $query, SearchContext $searchContext, ProductConfigurationRepository $productConfigurationRepository = null): JsonResponse
    {
        try {
            $searchIntent = new SearchIntent();
            $searchIntent->setSearch(json_decode($query));

            $searchConcreteStrategy = $this->getSearchConcreteStrategyInstance($searchIntent->getSearchType(), $productConfigurationRepository);

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
