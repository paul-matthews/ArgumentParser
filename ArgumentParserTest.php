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
        $this->assertSame(array(), $this->ap->parse(array('--foo=bar')));
    }

    public function testParserOnlyParseValidOptionsMissingQuotesForShortOpt()
    {
        $this->assertSame(array(), $this->ap->parse(array('-f=bar')));
    }

    public function testParserOnlyParseValidOptionsExceptsMissingDashes()
    {
        $this->assertSame(array(), $this->ap->parse(array(7)));
    }

    public function testParserOnlyParseValidOptionsExceptsTooManyDashes()
    {
        $this->assertSame(array(), $this->ap->parse(array('---a')));
    }

    public function testParserAllowsShortOptionsWithNoValue()
    {
        $this->assertSame(array('a' => true), $this->ap->parse(array('-a')));
    }

    public function testParserAllowsLongOptionsWithNoValue()
    {
        $this->assertSame(array('foo' => true), $this->ap->parse(array('--foo')));
    }

    public function testSetAliasConfiguresAlias()
    {
        $fromKey = 'f';
        $toKey = 'foo';

        $this->ap->setAlias($fromKey, $toKey);

        $this->assertSame($toKey, $this->ap->getAlias($fromKey));
    }

    public function testParseConvertsAliasedKeysForShortopt()
    {
        $fromKey = 'f';
        $toKey = 'foo';

        $this->ap->setAlias($fromKey, $toKey);

        $this->assertSame(array($toKey => true), $this->ap->parse(array("-$fromKey")));
    }

    public function testParseConvertsAliasedKeysForLongopts()
    {
        $fromKey = 'f';
        $toKey = 'foo';

        $this->ap->setAlias($fromKey, $toKey);

        $this->assertSame(array($toKey => true), $this->ap->parse(array("--$fromKey")));
    }

    public function testSetOptionConfiguresMandatorOption()
    {
        $this->ap->setOptions('a:');

        $this->assertTrue(in_array('a', $this->ap->getOptions(ArgumentParser::MANDATORY)));
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
