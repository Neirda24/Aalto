<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Answer;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * AnswerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnswerRepository extends EntityRepository
{
    /**
     * @param int $limit
     *
     * @return Query
     */
    public function findMostRecentQuery($limit = 0)
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->addOrderBy('a.created', 'DESC');

        if ($limit > 0) {
            $qb
                ->setMaxResults($limit);
        }

        $query = $qb->getQuery();
        $query->useQueryCache(true);

        return $query;
    }

    /**
     * @param int $limit
     *
     * @return Answer[]|array
     */
    public function findMostRecent($limit = 0)
    {
        $query = $this->findMostRecentQuery($limit);
        $query->useResultCache(true);

        return $query->getResult();
    }
}
