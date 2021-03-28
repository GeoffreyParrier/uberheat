<?php

namespace App\Controller;

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
     * @return JsonResponse
     */
    public function searchAction(Request $request, SearchContext $searchContext): JsonResponse
    {
        $query = $request->getContent();

//        var_dump(json_decode($query));

        return $this->searchActionsLogic($query, $searchContext);
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
     * @return SearchStrategy The instance
     * @throws Exception if search type doesn't match with a strategy
     */
    private function getSearchConcreteStrategyInstance(string $searchType): SearchStrategy
    {
        $concreteStrategy = null;

        /** @noinspection PhpSwitchCanBeReplacedWithMatchExpressionInspection */
        switch ($searchType) {
            case GetProductConfigurationsSearchResultConcreteStrategy::getType():
                $concreteStrategy = new GetProductConfigurationsSearchResultConcreteStrategy();
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
     * @param String $query Extracted query string
     * @param SearchContext $searchContext SearchContext DependencyInjection
     * @return JsonResponse The action return
     */
    private function searchActionsLogic(string $query, SearchContext $searchContext): JsonResponse
    {
        try {
            $searchIntent = new SearchIntent();
            $searchIntent->setSearch(json_decode($query));

            $searchConcreteStrategy = $this->getSearchConcreteStrategyInstance($searchIntent->getSearchType());

            $searchContext->setStrategy($searchConcreteStrategy);

            $searchResult = $searchContext->execute($searchIntent);

            $searchResult = json_encode($searchResult);

            return $this->json([
                'error' => null,
                'data' => $searchResult
            ]);
        } catch (Exception $e) {
            return $this->json([
                'error' => [
                    'code' => 'HTTP_BAD_REQUEST',
                    'message' => $e->getMessage()
                ]
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
