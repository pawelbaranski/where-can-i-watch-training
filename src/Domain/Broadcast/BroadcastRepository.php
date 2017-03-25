<?php

namespace WhereCanIWatch\Domain\Broadcast;


interface BroadcastRepository
{
    /**
     * @param string $nameQuery
     * @param $finishDate \DateTime
     * @return Broadcast[]
     */
    public function findNotFinishedBefore($nameQuery, \DateTime $finishDate);
}