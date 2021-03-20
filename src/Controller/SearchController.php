<?php

namespace App\Controller;


use App\Factories\SearchResultFactory;
use App\Search\ProductConfigurationSearchResult;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController {

    /**
     * @Route("/search", name="search", methods={"GET"})
     * @param Request $request
     * @param SearchResultFactory $searchResultFactory
     * @return JsonResponse
     */
    public function searchAction(Request $request, SearchResultFactory $searchResultFactory): JsonResponse
    {
        try {
            $query = $request->get('q');

            $searchResultObj = $searchResultFactory->getSearchResultObj(ProductConfigurationSearchResult::class);
            $searchResult = $searchResultObj->getSearchResult($query);

            return $this->json(['code' => 'SUCCESS', 'data' => $searchResult]);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/search/save", name="search-save", methods={"GET"})
     * @param Request $request
     * @param SearchResultFactory $searchResultFactory
     * @return JsonResponse
     */
    public function saveSearchAction(Request $request, SearchResultFactory $searchResultFactory): JsonResponse
    {
        try {
            $query = $request->get('q');

            $searchResultObj = $searchResultFactory->getSearchResultObj(ProductConfigurationSearchResult::class);
            $searchResult = $searchResultObj->saveSearchResult($query);

            return $this->json(['code' => 'SUCCESS', 'data' => $searchResult]);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
