<?php

namespace VulgarDetectorBundle\Normalizer;

class UniqueNormalizer implements Normalizer
{
    public function normalize($words)
    {
        return array_unique($words);
    }
}
