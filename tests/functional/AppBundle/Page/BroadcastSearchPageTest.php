<?php

namespace tests\functional\AppBundle\Page;


use Symfony\Component\DomCrawler\Crawler;
use tests\traits\DatabaseDictionary;
use tests\WebTestCase;
use WhereCanIWatch\Domain\Broadcast\Broadcast;
use WhereCanIWatch\Domain\Broadcast\TVChannel;

class BroadcastSearchPageTest extends WebTestCase
{
    use DatabaseDictionary;

    /** @var BroadcastSearchPage */
    private $page;

    protected function setUp()
    {
        parent::setUp();

        $this->page = null;

        $this->purgeDatabase();
    }

    /** @test */
    public function displaysFormWithNoResultsWhenOpened()
    {
        $this->assertExists($this->page()->searchForm());
        $this->assertDoesNotExist($this->page()->searchResults());
    }

    /** @test */
    public function displaysResultsIfFound()
    {
        $broadcast = new Broadcast(
            'Rambo',
            TVChannel::named('TVP 1'),
            new \DateTime('+1 hour'),
            new \DateTime('+2 hour')
        );

        $this->save($broadcast);

        $crawler = $this->client()->submit($this->page()->searchFor('Rambo'));

        $this->page()->refresh($crawler);

        $searchResults = $this->page()->searchResults();

        $this->assertExists($searchResults);
        $this->assertBroadcastExist($broadcast, $this->page()->searchResultAt(0));
    }

    private function assertExists($node)
    {
        $this->assertCount(1, $node);
    }

    private function assertDoesNotExist($node)
    {
        $this->assertCount(0, $node);
    }

    private function assertBroadcastExist(Broadcast $broadcast, Crawler $resultRow)
    {
        $this->assertContains($broadcast->name(), $resultRow->text());
        $this->assertContains((string) $broadcast->tvChannel(), $resultRow->text());
    }

    private function page()
    {
        if (!$this->page) {
            $this->page = new BroadcastSearchPage($this->client()->request('GET', '/search'));
        }

        return $this->page;
    }
}