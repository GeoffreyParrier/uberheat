<?php

namespace App\Repository;

use App\Entity\RectProductConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RectProductConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method RectProductConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method RectProductConfiguration[]    findAll()
 * @method RectProductConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RectProductConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RectProductConfiguration::class);
    }

    // /**
    //  * @return RectProductConfiguration[] Returns an array of RectProductConfiguration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @param $searched_id
     * @return RectProductConfiguration|null
     * @throws NonUniqueResultException
     */
    public function findOneById($searched_id): ?RectProductConfiguration
    {
        return $this->createQueryBuilder('rpc')
            ->andWhere('rpc.id = :id')
            ->setParameter('id', $searched_id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
