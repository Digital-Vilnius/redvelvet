<?php

namespace App\Repository;

use App\Entity\Photo;
use App\Model\Paging;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    public function listPhotos(Paging $paging = null)
    {
        $qb = $this->createQueryBuilder('photo');
        if ($paging) $this->applyPaging($qb, $paging);
        return $qb->getQuery()->getResult();
    }

    public function countPhotos()
    {
        $qb = $this->createQueryBuilder('photo')
            ->select('COUNT(photo.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    private function applyPaging(QueryBuilder $qb, Paging $paging = null)
    {
        $qb->setFirstResult($paging->getOffset())->setMaxResults($paging->getLimit());
    }
}