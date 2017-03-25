<?php

namespace WhereCanIWatch\Domain\Broadcast;


class Broadcast
{
    private $name;

    private $tvChannel;

    private $startDate;

    private $endDate;

    public function __construct($name, TVChannel $tvChannel, \DateTime $startDate, \DateTime $endDate)
    {
        $this->name = $name;
        $this->tvChannel = $tvChannel;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return TVChannel
     */
    public function tvChannel()
    {
        return $this->tvChannel;
    }

    /**
     * @return \DateTime
     */
    public function startDate()
    {
        return $this->startDate;
    }

    /**
     * @return \DateTime
     */
    public function endDate()
    {
        return $this->endDate;
    }
}