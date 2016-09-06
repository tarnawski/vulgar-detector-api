<?php

namespace VulgarDetectorBundle\Service;

use Doctrine\ORM\EntityManager;
use VulgarDetectorBundle\Entity\Request;

class RequestService
{
    /** @var EntityManager */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function logRequest($ip, $text)
    {
        $request = new Request($ip, $text);
        $this->em->persist($request);
        $this->em->flush();
    }
}