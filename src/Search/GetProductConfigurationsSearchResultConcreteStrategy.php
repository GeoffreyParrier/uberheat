<?php


namespace App\Search;


class GetProductConfigurationsSearchResultConcreteStrategy implements SearchStrategy
{

    /**
     * {@inheritdoc}
     */
    static public function getType(): string
    {
        return 'ProductConfiguration';
    }

    /**
     * {@inheritdoc}
     */
    public function execute($searchIntent): string
    {
        return 'ProductConfigurationsSearchResult';
    }
}