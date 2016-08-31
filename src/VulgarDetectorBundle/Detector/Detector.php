<?php

namespace VulgarDetectorBundle\Detector;

interface Detector
{
    /**
     * @param array $words
     * @param string $language
     * @return bool
     */
    public function isVulgar($words, $language);
}
