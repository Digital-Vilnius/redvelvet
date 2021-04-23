<?php

namespace App\Repository;

use App\Entity\Product;
use App\Model\Paging;
use App\Model\ProductsFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProductBySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function listProducts(ProductsFilter $filter = null, Paging $paging = null)
    {
        $qb = $this->createQueryBuilder('product')
            ->join('product.category', 'category');

        if ($filter) $this->applyFilter($qb, $filter);
        if ($paging) $this->applyPaging($qb, $paging);
        return $qb->getQuery()->getResult();
    }

    public function listNewestProducts()
    {
        return $this->createQueryBuilder('product')
            ->orderBy('product.created', 'desc')
            ->setFirstResult(0)
            ->setMaxResults(8)
            ->getQuery()
            ->getResult();
    }

    public function countProducts(ProductsFilter $filter = null)
    {
        $qb = $this->createQueryBuilder('product')
            ->join('product.category', 'category')
            ->select('COUNT(product.id)');

        if ($filter) $this->applyFilter($qb, $filter);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getRelatedProducts(Product $product, int $count = 4)
    {
        $qb = $this->createQueryBuilder('product')
            ->join('product.category', 'category')
            ->where('product != :product')->setParameter('product', $product)
            ->andWhere('category = :category')->setParameter('category', $product->getCategory())
            ->setMaxResults($count);

        $result = $qb->getQuery()->getResult();

        if (count($result) === 0) {
            $qb = $this->createQueryBuilder('product')
                ->where('product != :product')->setParameter('product', $product)
                ->setMaxResults($count);

            $result = $qb->getQuery()->getResult();
        }

        return $result;
    }

    private function applyPaging(QueryBuilder $qb, Paging $paging = null)
    {
        $qb->setFirstResult($paging->getOffset())->setMaxResults($paging->getLimit());
    }

    private function applyFilter(QueryBuilder $qb, ProductsFilter $filter)
    {
        if ($filter->getCategory())
        {
            $descendants = $filter->getCategory()->getDescendants();
            $descendants[] = $filter->getCategory();
            $qb->andWhere('category in (:descendants)')->setParameter('descendants', $descendants);
        }
    }
}