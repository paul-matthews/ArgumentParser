<?php

class ArgumentParserTest extends PHPUnit_Framework_TestCase
{
    public function testParserConvertsShortOptionsToBooleans()
    {
        $ap = new ArgumentParser();

        $this->assert(array('a' => true), $ap->parse('-a'));
    }
}
