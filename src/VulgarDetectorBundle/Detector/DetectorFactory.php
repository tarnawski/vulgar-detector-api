<?php

namespace VulgarDetectorBundle\Detector;

class DetectorFactory
{
    const COMPARE = 'COMPARE';
    const SIMILAR = 'SIMILAR';

    /** @var CompareDetector */
    private $compareDetector;

    /** @var SimilarDetector */
    private $similarDetector;

    public function __construct(
        CompareDetector $compareDetector,
        SimilarDetector $similarDetector
    ) {
        $this->compareDetector = $compareDetector;
        $this->similarDetector = $similarDetector;
    }

    /**
     * @param array $words
     * @param array $types
     * @param string $language
     * @return bool
     */
    public function isVulgar($words, $types, $language = null)
    {
        if (in_array(self::COMPARE, $types)) {
            $result = $this->compareDetector->isVulgar($words, $language);
            if ($result) {
                return true;
            }
        }
        if (in_array(self::SIMILAR, $types)) {
            $result = $this->similarDetector->isVulgar($words, $language);
            if ($result) {
                return true;
            }
        }

        return false;
    }
}
