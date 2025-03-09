<?php

namespace App\Repository;

use App\Entity\Calculation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CalculationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calculation::class);
    }

    /**
     * Find paginated calculations.
     */
    public function findPaginatedCalculations($sort = 'id', $order = 'DESC', $limit = 5, $offset = 0)
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.' . $sort, $order)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}
