<?php

namespace VulgarDetectorBundle\Normalizer;

class LowercaseNormalizer implements Normalizer
{
    public function normalize($words)
    {
        $normalizeWords = [];
        foreach ($words as $word) {
            $normalizeWords[] = mb_strtolower($word, 'utf-8');
        }

        return $normalizeWords;
    }
}
