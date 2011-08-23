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
        $this->assertSame(
            array('a' => true, 'b' => true, 'c' => true),
            $this->ap->parse(array('-abc'))
        );
    }

    public function testParserConvertsManySeparatedShortOptionsTogetherToBooleans()
    {
        $this->assertSame(
            array(
                'a' => true, 'b' => true, 'c' => true,
                'd' => true, 'e' => true, 'f' => true,
            ),
            $this->ap->parse(array('-abc', '-def'))
        );
    }

    public function testParserConvertsLongOptionsIntoBooleans()
    {
        $this->assertSame(
            array('foo' => true),
            $this->ap->parse(array('--foo'))
        );
    }

    public function testParserConvertsManyLongOptionsIntoBooleans()
    {
        $this->assertSame(
            array('foo' => true, 'bar' => true),
            $this->ap->parse(array('--foo', '--bar'))
        );
    }

    public function testParserAddsTheValueToEqualSignedSeparatedLongOptions()
    {
        $this->assertSame(
            array('foo' => 'bar'),
            $this->ap->parse(array('--foo="bar"'))
        );
    }

    public function testParserOnlyParseValidOptionsMissingQuotes()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->ap->parse(array('--foo=bar'));
    }

    public function testParserOnlyParseValidOptionsMissingQuotesForShortOpt()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->ap->parse(array('-f=bar'));
    }

    public function testParserOnlyParseValidOptionsExceptsMissingDashes()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->ap->parse(array(7));
    }

    public function testParserOnlyParseValidOptionsExceptsTooManyDashes()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->ap->parse(array('---a'));
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
