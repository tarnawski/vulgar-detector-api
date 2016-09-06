<?php

namespace VulgarDetectorBundle\Entity;

class Request
{
    /** @var string */
    private $ip;

    /** @var \DateTime */
    private $date;

    /** @var string */
    private $text;

    public function __construct($ip, $text)
    {
        $this->ip = $ip;
        $this->date = new \DateTime();
        $this->text = $text;
    }
}
