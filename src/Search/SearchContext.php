<?php


namespace App\Search;


class SearchContext
{
    /**
     * @var SearchStrategy
     */
    private SearchStrategy $strategy;

    /**
     * SearchContext constructor.
     * @param SearchStrategy|null $strategy
     */
    public function __construct(SearchStrategy $strategy = null)
    {
        $this->$strategy = $strategy;
    }

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
     */
    public function execute(SearchIntent $searchIntent)
    {
        return $this->strategy->execute($searchIntent);
    }
}
