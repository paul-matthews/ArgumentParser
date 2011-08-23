<?php
require_once(__DIR__ . '/ArgumentParser.php');

class ArgumentParserTest extends PHPUnit_Framework_TestCase
{
    public function testParserConvertsShortOptionsToBooleans()
    {
        $ap = new ArgumentParser();

        $this->assertSame(array('a' => true), $ap->parse('-a'));
    }
}
