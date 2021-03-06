<?php

namespace App\ProjectBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
    public function getAllProducts()
    {
        return $this->getEntityManager()
            ->createQuery("SELECT p FROM AppProjectBundle:Product p");
    }

    public function findRelated($paramsArray)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where($qb->expr()->not($qb->expr()->eq('a.id', '?1')));
        $qb->setParameter(1, $paramsArray['id']);
        $qb->andWhere($qb->expr()->eq('a.category', '?2'));
        $qb->setParameter(2, $paramsArray['category']);

        return $qb->getQuery()
            ->getResult();
    }
}
