<?php

namespace spec\VulgarDetectorBundle\Normalizer;

use VulgarDetectorBundle\Normalizer\LowercaseNormalizer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use VulgarDetectorBundle\Normalizer\Normalizer;

class LowercaseNormalizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LowercaseNormalizer::class);
        $this->shouldImplement(Normalizer::class);
    }

    function it_should_normalize()
    {
        $words = ["NormaliZer", "TeSt"];

        $result = $this->normalize($words);

        $result->shouldHaveCount(2);
        $result->shouldContain('normalizer');
        $result->shouldContain('test');
    }
}
