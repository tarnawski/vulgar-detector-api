<?php

namespace VulgarDetectorBundle\Entity;

class Request
{
    /** @var integer */
    private $id;

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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
