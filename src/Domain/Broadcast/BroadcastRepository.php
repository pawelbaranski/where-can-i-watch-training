<?php

namespace WhereCanIWatch\Domain\Broadcast;


interface BroadcastRepository
{
    /**
     * @param string $nameQuery
     * @param $finishDate \DateTime
     * @return Broadcast[]
     */
    public function findNotFinished($nameQuery, \DateTime $finishDate);

    /**
     * @param $finishDate \DateTime
     * @return Broadcast[]
     */
    public function findNotFinishedOrderedByTVChannelAndStartDate(\DateTime $finishDate);
}