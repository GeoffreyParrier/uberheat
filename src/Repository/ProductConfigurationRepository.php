<?php

namespace App\Repository;

use App\Entity\ProductConfiguration;
use App\Entity\SearchIntent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductConfiguration[]    findAll()
 * @method ProductConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductConfiguration::class);
    }

    /**
     * Request product_conf_view
     *
     * @param SearchIntent $searchIntent
     * @return array
     * @throws Exception
     */
    public function getAllProductWithItConfigurations(SearchIntent $searchIntent): array
    {
        $conditions = $searchIntent->getConditions();

        $query = /** @lang SQL */
            "SELECT * FROM product_conf_view";


        if (count($conditions) > 0) {
            foreach ($conditions as $index => $condition) {
                if ($index === 0) {
                    $query .= ' WHERE ' . $condition->property . ' ' . $condition->rule . ' ' . $condition->value;
                } else {
                    $query .= ' AND ' . $condition->property . ' ' . $condition->rule . ' ' . $condition->value;
                }
            }
        }

        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAll();
    }
}
