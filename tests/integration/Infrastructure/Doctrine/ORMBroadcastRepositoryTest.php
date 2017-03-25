<?php

namespace tests\integration\Infrastructure\Doctrine;


use tests\IntegrationTestCase;
use WhereCanIWatch\Domain\Broadcast\Broadcast;
use WhereCanIWatch\Domain\Broadcast\TVChannel;
use WhereCanIWatch\Infrastructure\Doctrine\ORMBroadcastRepository;

class ORMBroadcastRepositoryTest extends IntegrationTestCase
{

    /** @var ORMBroadcastRepository */
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->repository = $this->container()->get('app.broadcast_repository.orm');
        $this->purgeDatabase();
    }

    /** @test */
    public function findsNotFinishedBroadcasts()
    {
        $finishedBroadcast1 = new Broadcast(
            'test',
            TVChannel::named('test-ch1'),
            new \DateTime('yesterday'),
            new \DateTime('yesterday')
        );

        $notFinishedBroadcast1 = new Broadcast(
            'test',
            TVChannel::named('test-ch1'),
            new \DateTime('now'),
            new \DateTime('+1 hour')
        );

        $notFinishedBroadcast2 = new Broadcast(
            'test',
            TVChannel::named('test-ch1'),
            new \DateTime('+1 hour'),
            new \DateTime('+2 hour')
        );

        $this->saveAll([$finishedBroadcast1, $notFinishedBroadcast1, $notFinishedBroadcast2]);

        $found = $this->repository->findNotFinishedBefore('test', new \DateTime('-1 hour'));

        $this->assertCount(2, $found);
        $this->assertContains($notFinishedBroadcast1, $found);
        $this->assertContains($notFinishedBroadcast2, $found);
    }

    /** @test */
    public function doesNotFindNotFinishedBroadcastIfNameDoesNotMatch()
    {
        $notFinishedBroadcast = new Broadcast(
            'test',
            TVChannel::named('test-ch1'),
            new \DateTime('now'),
            new \DateTime('+1 hour')
        );

        $this->save($notFinishedBroadcast);

        $this->assertSame([], $this->repository->findNotFinishedBefore('some', new \DateTime('-1 hour')));
    }

    /** @test */
    public function notFinishedBroadcastsAreOrderedByEndDate()
    {
        $notFinishedBroadcast1 = new Broadcast(
            'test',
            TVChannel::named('test-ch1'),
            new \DateTime('+1 hour'),
            new \DateTime('+2 hour')
        );

        $notFinishedBroadcast2 = new Broadcast(
            'test',
            TVChannel::named('test-ch1'),
            new \DateTime('now'),
            new \DateTime('+1 hour')
        );

        $notFinishedBroadcast3 = new Broadcast(
            'test',
            TVChannel::named('test-ch1'),
            new \DateTime('+3 hour'),
            new \DateTime('+4 hour')
        );

        $this->saveAll([$notFinishedBroadcast1, $notFinishedBroadcast2, $notFinishedBroadcast3]);

        $found = $this->repository->findNotFinishedBefore('test', new \DateTime());

        $this->assertEquals([
            $notFinishedBroadcast2,
            $notFinishedBroadcast1,
            $notFinishedBroadcast3
        ], $found);
    }

    /** @test */
    public function returnsEmptyArrayIfThereAreNoBroadcastsFound()
    {
        $this->assertSame([], $this->repository->findNotFinishedBefore('test', new \DateTime()));
    }
}