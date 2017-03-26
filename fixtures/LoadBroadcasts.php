<?php

namespace fixtures;


use Doctrine\Common\DataFixtures\FixtureInterface;
use WhereCanIWatch\Domain\Broadcast\Broadcast;
use WhereCanIWatch\Domain\Broadcast\TVChannel;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBroadcasts implements FixtureInterface
{
    const NAME = 0;
    const TV_CHANNEL = 1;
    const START_DATE = 2;
    const END_DATE = 3;
    const NOW_DIFF = 0;
    const HOUR = 1;

    private $broadcastsData = [
        ['Rodzina Soprano odc. 22', 'HBO', ['yesterday', 20], ['yesterday', 21]],
        ['Idol', 'Polsat', ['yesterday', 20], ['yesterday', 21]],
        ['Teleexpress', 'TVP 1', ['today', 17], ['today', 18]],
        ['Informacje', 'Polsat', ['today', 19], ['today', 20]],
        ['Pytanie na śniadanie', 'TVP 1', ['today', 9], ['today', 10]],
        ['Makłowicz w podróży', 'TVP 2', ['today', 9], ['today', 10]],
        ['Familiada', 'TVP 2', ['today', 14], ['today', 15]],
        ['Teleexpress', 'TVP 1', ['today', 17], ['today', 18]],
        ['Informacje', 'Polsat', ['today', 19], ['today', 20]],
        ['Liga Mistrzów: Benfica - Bayern', 'TVP 2', ['today', 20], ['today', 22]],
        ['Piła', 'Polsat', ['today', 20], ['today', 22]],
        ['Rodzina Soprano odc. 23', 'HBO', ['today', 20], ['today', 21]],
        ['Rambo', 'TVP 1', ['today', 20], ['today', 22]],
        ['Rambo II', 'TVP 1', ['today', 22], ['today', 24]],
        ['Rambo III', 'TVP 1', ['today', 24], ['tomorrow', 2]],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->broadcastsData as $data) {
            $broadcast = new Broadcast(
                $data[self::NAME],
                TVChannel::named($data[self::TV_CHANNEL]),
                $this->getDate($data[self::START_DATE]),
                $this->getDate($data[self::END_DATE])
            );

            $manager->persist($broadcast);
        }

        $manager->flush();
    }

    private function getDate($dateArray)
    {
        $date = new \DateTime($dateArray[self::NOW_DIFF]);
        $date->setTime($dateArray[self::HOUR], 0, 0);

        return $date;
    }
}