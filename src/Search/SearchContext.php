<?php


namespace App\Search;


use App\Entity\SearchIntent;

class SearchContext
{
    /**
     * @var SearchStrategy
     */
    private SearchStrategy $strategy;

    /**
     * @return SearchStrategy
     */
    public function getStrategy(): SearchStrategy
    {
        return $this->strategy;
    }

    /**
     * @param SearchStrategy $strategy
     */
    public function setStrategy(SearchStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * @param SearchIntent $searchIntent
     * @return array
     */
    public function execute(SearchIntent $searchIntent): array
    {
        return $this->strategy->execute($searchIntent);
    }
}
