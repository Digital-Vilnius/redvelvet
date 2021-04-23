<?php

namespace App\Repository;

use App\Entity\Category;
use App\Model\CategoriesFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getCategoryBySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function listRootCategories()
    {
        return $this->createQueryBuilder('category')
            ->leftJoin('category.parent', 'parent')
            ->andWhere('parent is null')
            ->getQuery()
            ->getResult();
    }

    public function listCategories(CategoriesFilter $filter = null)
    {
        $qb = $this->createQueryBuilder('category')
            ->leftJoin('category.parent', 'parent');

        if ($filter) $this->applyFilter($qb, $filter);

        return $qb->getQuery()->getResult();
    }

    public function countCategories(CategoriesFilter $filter = null)
    {
        $qb = $this->createQueryBuilder('category')
            ->select('COUNT(category.id)')
            ->leftJoin('category.parent', 'parent');

        if ($filter) $this->applyFilter($qb, $filter);

        return $qb->getQuery()->getSingleScalarResult();
    }


    private function applyFilter(QueryBuilder $qb, CategoriesFilter $filter)
    {
        if ($filter->getParent() !== null) {
            $qb->andWhere('parent = :parent')->setParameter('parent', $filter->getParent());
        }

        if ($filter->getParent() === null) {
            $qb->andWhere('parent is null');
        }
    }
}