<?php

namespace VulgarDetectorBundle\Detector;

use VulgarDetectorBundle\Entity\Word;
use VulgarDetectorBundle\Repository\WordRepository;

class SimilarDetector implements Detector
{
    /** @var WordRepository */
    private $wordRepository;

    /** @var string */
    private $defaultThreshold;

    public function __construct(WordRepository $wordRepository, $defaultThreshold)
    {
        $this->wordRepository = $wordRepository;
        $this->defaultThreshold = $defaultThreshold;
    }

    /**
     * @param array $words
     * @param string $language
     * @return integer
     */
    public function isVulgar($words, $language = null)
    {
        $dictionary = $this->wordRepository->getCountWords($language);
        foreach ($words as $word){
            /** @var Word $item */
            foreach ($dictionary as $item) {
                similar_text($word, $item->getName(), $similarTextPercent);
                if ($similarTextPercent > $this->defaultThreshold) {
                    return true;
                }
            }
        }

        return false;
    }
}
