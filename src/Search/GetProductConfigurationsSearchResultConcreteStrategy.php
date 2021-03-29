<?php


namespace App\Search;


use App\Repository\ProductConfigurationRepository;
use Doctrine\DBAL\Exception;

class GetProductConfigurationsSearchResultConcreteStrategy implements SearchStrategy
{
    private ProductConfigurationRepository $productConfigurationRepository;

    /**
     * {@inheritdoc}
     */
    static public function getType(): string
    {
        return 'ProductConfiguration';
    }

    public function __construct(ProductConfigurationRepository $productConfigurationRepository)
    {
        $this->productConfigurationRepository = $productConfigurationRepository;
    }


    /**
     * {@inheritdoc}
     * @return array
     * @throws Exception
     */
    public function execute($searchIntent): array
    {
        return $this->productConfigurationRepository->getAllProductWithItConfigurations($searchIntent);
    }
}