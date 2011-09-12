<?php
require_once dirname(__DIR__) . '/app/ArgumentParser.php';

class ArgumentParserTest extends PHPUnit_Framework_TestCase
{
    public function testShortOptionReturnsValue()
    {
        $this->ap->addOption('a');

        $this->assertSame(array('a' => true), $this->ap->parse(array('-a')));
    }

    public function testLongOptionReturnsValue()
    {
        $this->ap->addLongOption('test');
        $this->assertSame(array('test' => true), $this->ap->parse('--test'));
    }

    public function testShortOptionWithValue()
    {
        $this->ap->addOption('a::');
        $this->ap->addOption('b::');

        $this->assertSame(
            array('a' => true, 'b' => 'test'),
            $this->ap->parse(array('-a', '-b="test"'))
        );
    }

    public function setUp()
    {
        $this->ap = new ArgumentParser();
    }
}
