<?php


namespace App\Search;


use App\Entity\SearchIntent;

interface SearchStrategy
{
    /**
     * @return string Search type used for recognize the SearchConcreteStrategy to use according to query.
     */
    static public function getType(): string;

    /**
     * Execute SearchConcreteStrategy business logic
     *
     * @param $searchIntent
     * @return array
     */
    public function execute(SearchIntent $searchIntent): array;
}
