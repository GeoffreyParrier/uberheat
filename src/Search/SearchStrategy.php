<?php


namespace App\Search;


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
     */
    public function execute($searchIntent);
}
