<?php

namespace VulgarDetectorBundle\Detector;

use VulgarDetectorBundle\Repository\WordRepository;

class StaticDetector implements Detector
{
    /** @var WordRepository */
    private $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    /**
     * @param array $words
     * @param string $language
     * @return integer
     */
    public function isVulgar($words, $language = null)
    {
        $count = $this->wordRepository->getCountWordsByArray($words, $language);

        return ($count === 0) ? false : true;
    }
}
