<?php

namespace VulgarDetectorBundle\Detector;

use Lsw\MemcacheBundle\Doctrine\Cache\MemcacheCache;
use VulgarDetectorBundle\Entity\Word;
use VulgarDetectorBundle\Repository\WordRepository;

class SimilarDetector implements Detector
{
    /** @var WordRepository */
    private $wordRepository;

    /** @var  MemcacheCache */
    private $cache;

    /** @var string */
    private $memcacheTTL;

    /** @var string */
    private $defaultThreshold;

    public function __construct(
        WordRepository $wordRepository,
        MemcacheCache $memcacheCache,
        $memcacheTTL,
        $defaultThreshold
    ) {
        $this->wordRepository = $wordRepository;
        $this->cache = $memcacheCache;
        $this->memcacheTTL = $memcacheTTL;
        $this->defaultThreshold = $defaultThreshold;
    }

    /**
     * @param array $words
     * @param string $language
     * @return integer
     */
    public function isVulgar($words, $language = null)
    {
        $dictionary = $this->getDictionary($language);

        foreach ($words as $word) {
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

    public function getDictionary($language = null)
    {
        $index = isset($language) ? sprintf('DICTIONARY-%s', strtoupper($language)) : 'DICTIONARY';

        if ($this->cache->get($index)) {
            $dictionary = $this->cache->get($index);
        } else {
            $dictionary = $this->wordRepository->getWordsByLanguage($language);
            $this->cache->set($index, $dictionary, false, $this->memcacheTTL);

        }

        return $dictionary;
    }
}
