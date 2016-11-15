<?php

namespace spec\VulgarDetectorBundle\Service;

use Doctrine\ORM\EntityManager;
use VulgarDetectorBundle\Service\RequestService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestServiceSpec extends ObjectBehavior
{
    function let(EntityManager $entityManager)
    {
        $this->beConstructedWith($entityManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RequestService::class);
    }

    function it_should_log_request(EntityManager $entityManager)
    {
        $ip = '10.10.0.200';
        $text = 'Spimple text';
        $this->beConstructedWith($entityManager);

        $this->logRequest($ip, $text);

        $entityManager->flush()->shouldBeCalled();
    }
}
