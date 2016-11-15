<?php

namespace spec\VulgarDetectorBundle\Normalizer;

use VulgarDetectorBundle\Normalizer\Normalizer;
use VulgarDetectorBundle\Normalizer\StopWordsNormalizer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StopWordsNormalizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StopWordsNormalizer::class);
        $this->shouldImplement(Normalizer::class);
    }

    function it_should_normalize()
    {
        $words = ["its", "normalizer", "test"];

        $result = $this->normalize($words);

        $result->shouldHaveCount(2);
        $result->shouldContain('normalizer');
        $result->shouldContain('test');
    }
}
