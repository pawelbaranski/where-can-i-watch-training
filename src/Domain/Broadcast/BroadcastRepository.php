<?php

namespace WhereCanIWatch\Domain\Broadcast;


interface BroadcastRepository
{
    /**
     * @param string $name
     * @return Broadcast[]
     */
    public function findAllNotFinished($name);
}