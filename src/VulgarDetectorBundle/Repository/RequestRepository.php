<?php

namespace VulgarDetectorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class RequestRepository
 */
class RequestRepository extends EntityRepository
{
    public function getCountRequestByIp($ip)
    {
        $date = new \DateTime();

        $result = $this->createQueryBuilder('r')
            ->select('COUNT(r)')
            ->where('r.ip = :ip')
            ->andWhere('r.date = :date')
            ->setParameters([
                'ip' => $ip,
                'date' => $date->format('Y-m-d')
            ])
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $result;
    }

    public function getCountRequest()
    {
        $result = $this->createQueryBuilder('r')
            ->select('COUNT(r)')
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $result;
    }

    public function getCountRequestToday()
    {
        $date = new \DateTime();

        $result = $this->createQueryBuilder('r')
            ->select('COUNT(r)')
            ->andWhere('r.date = :date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $result;
    }
}
