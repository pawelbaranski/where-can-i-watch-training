<?php

namespace WhereCanIWatch\Domain\Broadcast;


class TVChannel
{
    private $name;

    private function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return TVChannel
     */
    public static function named($name)
    {
        return new self($name);
    }

    public function __toString()
    {
        return $this->name;
    }
}