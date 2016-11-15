<?php

namespace spec\VulgarDetectorBundle\Tokenizer;

use VulgarDetectorBundle\Tokenizer\Tokenizer;
use VulgarDetectorBundle\Tokenizer\WordTokenizer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WordTokenizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(WordTokenizer::class);
        $this->shouldImplement(Tokenizer::class);
    }

    function it_should_tokenize()
    {
        $str = "Word tokenizer test";

        $result = $this->tokenize($str);

        $result->shouldHaveCount(3);
        $result->shouldContain('Word');
        $result->shouldContain('tokenizer');
        $result->shouldContain('test');
    }
}
