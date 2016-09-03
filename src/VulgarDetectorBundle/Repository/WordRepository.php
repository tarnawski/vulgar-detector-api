<?php

namespace VulgarDetectorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class WordRepository
 */
class WordRepository extends EntityRepository
{
    public function getWordsByLanguage($language = null)
    {
        $qb = $this->createQueryBuilder('w');
        $qb->select('w');
        if ($language) {
            $qb->andWhere('w.language = :language');
            $qb->setParameter('language', $language);
        }

        return $qb->getQuery()->getResult();
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
