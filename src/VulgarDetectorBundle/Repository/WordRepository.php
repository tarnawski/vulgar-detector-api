<?php

namespace VulgarDetectorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class WordRepository
 */
class WordRepository extends EntityRepository
{
    public function getCountWordsByArray($array, $language = null)
    {
        $qb = $this->createQueryBuilder('w');
        $qb->select('COUNT(w)');
        $qb->where('w.name IN (:array)');
        $qb->setParameter('array', $array);
        if ($language) {
            $qb->andWhere('w.language = :language');
            $qb->setParameter('language', $language);
        }

        return (int)$qb->getQuery()->getSingleScalarResult();
    }

    public function getWordsCount()
    {
        $result = $this->createQueryBuilder('w')
            ->select('COUNT(w)')
            ->getQuery()
            ->getSingleScalarResult();

        return $result;
    }

    public function getLanguagesCount()
    {
        $result = $this->createQueryBuilder('w')
            ->select('COUNT(DISTINCT w.language)')
            ->getQuery()
            ->getSingleScalarResult();

        return $result;
    }
}
