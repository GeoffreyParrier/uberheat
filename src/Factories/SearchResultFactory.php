<?php


namespace App\Factories;


use App\Search\AbstractSearchResult;
use App\Search\ProductConfigurationSearchResult;

class SearchResultFactory
{
    /**
     * @param String $searchType
     * @return ProductConfigurationSearchResult|null
     */
    public function getSearchResultObj(String $searchType): ?AbstractSearchResult
    {
        switch ($searchType) {
            case ProductConfigurationSearchResult::class :
                return new ProductConfigurationSearchResult();

                default:
                    return null;
        }
    }
}
