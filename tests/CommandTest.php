<?php

class CommandTest extends PHPUnit_Framework_TestCase
{
    public function testParseInvalidTestReturnsNull()
    {
        $go = new Getopt();

        $command = new Getopt_Item_Command('a');

        $req = $go->getRequest(array('foo'));

        $this->assertNull($command->parse($req));
    }

    public function testParseValidTestReturnsResponse()
    {
        $go = new Getopt();

        $command = new Getopt_Item_Command('a');

        $req = $go->getRequest(array('a'));

        $this->assertTrue($command->parse($req) instanceof Getopt_Response);
    }
}
