<?php

namespace VulgarDetectorBundle\Service;

use Doctrine\ORM\EntityManager;
use VulgarDetectorBundle\Repository\RequestRepository;
use VulgarDetectorBundle\Entity\Request;

class RequestService
{
    /** @var EntityManager */
    private $em;

    /** @var  RequestRepository */
    private $requestRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->requestRepository = $entityManager->getRepository(Request::class);
    }

    public function getRequestByIp($ip)
    {
        $count = $this->requestRepository->getCountRequestByIp($ip);

        return $count;
    }

    public function logRequest($ip, $text)
    {
        $request = new Request($ip, $text);
        $this->em->persist($request);
        $this->em->flush();
    }
}