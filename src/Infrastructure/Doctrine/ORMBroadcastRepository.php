<?php

namespace WhereCanIWatch\Infrastructure\Doctrine;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use WhereCanIWatch\Domain\Broadcast\Broadcast;
use WhereCanIWatch\Domain\Broadcast\BroadcastRepository;

class ORMBroadcastRepository implements BroadcastRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findNotFinished($nameQuery, \DateTime $finishDate)
    {
        return $this
            ->findAllNotFinishedQuery($finishDate)
            ->andWhere('b.name = :nameQuery')
            ->setParameter('nameQuery', $nameQuery)
            ->orderBy('b.endDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findNotFinishedOrderedByTVChannelAndStartDate(\DateTime $finishDate)
    {
        return $this
            ->findAllNotFinishedQuery($finishDate)
            ->orderBy('b.tvChannel.name', 'ASC')
            ->addOrderBy('b.startDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    private function findAllNotFinishedQuery(\DateTime $finishDate)
    {
        return $this
            ->repository()
            ->createQueryBuilder('b')
            ->where('b.endDate > :finishDate')
            ->setParameter('finishDate', $finishDate);
    }

    /**
     * @return EntityRepository
     */
    private function repository()
    {
        return $this
            ->entityManager
            ->getRepository(Broadcast::class);
    }
}