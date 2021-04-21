<?php

namespace App\Repository;

use App\Entity\Product;
use App\Model\Paging;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findProducts(Paging $paging = null)
    {
        $qb = $this->createQueryBuilder('product');
        $this->applyPaging($qb, $paging);
        return $qb->getQuery()->getResult();
    }

    private function applyPaging(QueryBuilder $qb, Paging $paging = null)
    {
        if ($paging) $qb->setFirstResult($paging->getOffset())->setMaxResults($paging->getLimit());
    }
}