<?php

namespace VulgarDetectorBundle\Tokenizer;

interface Tokenizer
{
    /**
     * @param string $text
     */
    public function tokenize($text);
}
