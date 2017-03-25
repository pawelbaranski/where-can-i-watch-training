<?php

namespace tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use tests\traits\DatabaseDictionary;

abstract class IntegrationTestCase extends WebTestCase
{
    use DatabaseDictionary;

    /** @var ContainerInterface */
    private $container;

    /**
     * @return ContainerInterface
     */
    protected function container()
    {
        return $this->container;
    }

    protected function setUp()
    {
        parent::setUp();

        $this->container = static::createClient()->getContainer();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}
