<?php

namespace spec\VulgarDetectorBundle\Normalizer;

use VulgarDetectorBundle\Normalizer\Normalizer;
use VulgarDetectorBundle\Normalizer\UniqueNormalizer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UniqueNormalizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UniqueNormalizer::class);
        $this->shouldImplement(Normalizer::class);
    }

    function it_should_normalize()
    {
        $words = ["normalizer", "test", "normalizer", "test"];

        $result = $this->normalize($words);

        $result->shouldHaveCount(2);
        $result->shouldContain('normalizer');
        $result->shouldContain('test');
    }
}
