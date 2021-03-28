<?php


namespace App\Search;


class SaveProductConfigurationSearchResultConcreteStrategy implements SearchStrategy
{
    /**
     * {@inheritdoc}
     */
    static public function getType(): string
    {
        return 'SaveProductConfiguration';
    }

    /**
     * {@inheritdoc}
     */
    public function execute($searchIntent): mixed
    {
        return 'SavedProductConfigurationsSearchResult';
    }
}