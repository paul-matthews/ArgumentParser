<?php
require_once __DIR__ . '/ArgumentParser.php';

class ArgumentParserTest extends PHPUnit_Framework_TestCase
{
    public function testParseConvertsShortOptionsToBooleans()
    {
        $this->assertSame($this->getTrueForKeys('a'), $this->ap->parse(array('-a')));
    }

    public function testParseConvertsManyShortOptionsIntoBooleans()
    {
        $this->assertSame($this->getTrueForKeys('ab'), $this->ap->parse(array('-a', '-b')));
    }

    public function testParseConvertsManyShortOptionsTohetherIntoBooleans()
    {
        $this->assertSame($this->getTrueForKeys('abc'), $this->ap->parse(array('-abc')));
    }

    public function testParseConvertsManySeparatedShortOptionsTogetherIntoBooleans()
    {
        $this->assertSame($this->getTrueForKeys('abcdef'), $this->ap->parse(array('-abc', '-def')));
    }

    public function testParseConvertsLongOptionsIntoBooleans()
    {
        $this->assertSame($this->getTrueForKeys(array('foo')), $this->ap->parse(array('--foo')));
    }

    public function testParseConvertsManyLongOptionsIntoBooleans()
    {
        $this->assertSame($this->getTrueForKeys(array('foo', 'bar')), $this->ap->parse(array('--foo', '--bar')));
    }

    public function testParseAddsTheValueToEqualSignedSeparatedLongOptions()
    {
        $this->assertSame(array('foo' => 'bar'), $this->ap->parse(array('--foo="bar"')));
    }

    public function testPraseOnlyParseValidOptions()
    {
        $this->assertSame(array(), $this->ap->parse(array(
            'foo',
            '--foo=blah',
            'f',
        )));
    }

    public function setUp()
    {
        $this->ap = new ArgumentParser();
    }

    public function tearDown()
    {
        unset($this->ap);
    }

    protected function getTrueForKeys($keys)
    {
        if (is_string($keys)) {
            $keys = str_split($keys);
        }

        return array_fill_keys($keys, true);
    }
}
