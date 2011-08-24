<?php
require_once __DIR__ . '/ArgumentParser.php';

class ArgumentParserTest extends PHPUnit_Framework_TestCase
{
    public function testParseConvertsShortOptionsToBooleans()
    {
        $ap = new ArgumentParser();

        $this->assertSame(array('a' => true), $ap->parse(array('-a')));
    }
}
