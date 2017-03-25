<?php

namespace tests\unit\Domain\Broadcast;


use WhereCanIWatch\Domain\Broadcast\TVChannel;

class TVChannelTest extends \PHPUnit_Framework_TestCase
{
    /** @test **/
    public function isCreatedUsingName()
    {
        $this->assertInstanceOf(TVChannel::class, TVChannel::named('test name'));
    }

    /** @test **/
    public function hasStringRepresentation()
    {
        $this->assertEquals('test name', (string) TVChannel::named('test name'));
    }
}
