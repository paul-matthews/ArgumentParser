<?php

class CommandTest extends PHPUnit_Framework_TestCase
{
    const DEFAULT_NAME = 'test';

    public function testSetCommandName()
    {
        $this->assertSame(self::DEFAULT_NAME, $this->static->getName());
    }

    public function testSetShortOption()
    {
        $this->static->addOption(new Getopt_Command_Option_Short('a'));

        $this->assertTrue($this->static->getOption('a') instanceof Getopt_Command_Option_Short);
    }

    public function testSetShortOptionString()
    {
        $this->static->addOptions('a');

        $this->assertTrue($this->static->getOption('a') instanceof Getopt_Command_Option_Short);
    }

    public function setUp()
    {
        $this->static = new Getopt_Command_Static(self::DEFAULT_NAME);
    }
}
