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

    public function findNotFinishedBefore($nameQuery, \DateTime $finishDate)
    {
        return $this
            ->repository()
            ->createQueryBuilder('b')
            ->select('b')
            ->where('b.endDate > :finishDate')
            ->andWhere('b.name = :nameQuery')
            ->setParameter('finishDate', $finishDate)
            ->setParameter('nameQuery', $nameQuery)
            ->orderBy('b.endDate', 'ASC')
            ->getQuery()
            ->getResult();
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