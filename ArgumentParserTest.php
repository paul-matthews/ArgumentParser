<?php
require_once(__DIR__ . '/ArgumentParser.php');

class ArgumentParserTest extends PHPUnit_Framework_TestCase
{
    public function testParserConvertsShortOptionsToBooleans()
    {
        $this->assertSame(array('a' => true), $this->ap->parse(array('-a')));
    }

    public function testParserConvertsManyShortOptionsToBooleans()
    {
        $this->assertSame(array('a' => true, 'b' => true), $this->ap->parse(array('-a', '-b')));
    }

    public function testParserConvertsManyShortOptionsTogetherToBooleans()
    {
        $this->assertSame(array('a' => true, 'b' => true, 'c' => true), $this->ap->parse(array('-abc')));
    }

    public function setUp()
    {
        $this->ap = new ArgumentParser();
    }

    public function tearDown()
    {
        unset($this->ap);
    }
}
