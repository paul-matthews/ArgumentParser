<?php
require_once __DIR__ . '/Bootstrap.php';

class ArgumentParserTest extends PHPUnit_Framework_TestCase
{
    public function testAddOptionSucceeds()
    {
        $this->ap->addOption(new Option_Short('a', new Argument_None()));
        $this->ap->addOption(new Option_Long('a', new Argument_None()));

        $this->assertSame(2, count($this->ap->getOptions()));
    }

    public function testAddOptionsWithNoValue()
    {
        $this->ap->addOptions('b');

        $this->checkOptionAdded('b', 'Option_Short', 'Argument_None');
    }

    public function testAddOptionsWithMandatoryValue()
    {
        $this->ap->addOptions('b:');

        $this->checkOptionAdded('b', 'Option_Short', 'Argument_Mandatory');
    }

    public function testAddOptionsWithOptionalValue()
    {
        $this->ap->addOptions('b::');

        $this->checkOptionAdded('b', 'Option_Short', 'Argument_Optional');
    }

    public function testAddLongOptionsWithNoValue()
    {
        $this->ap->addLongOptions('bee');

        $this->checkOptionAdded('bee', 'Option_Long', 'Argument_None');
    }

    public function testAddLongOptionsWithMandatoryValue()
    {
        $this->ap->addLongOptions('bee:');

        $this->checkOptionAdded('bee', 'Option_Long', 'Argument_Mandatory');
    }

    public function testAddLongOptionsWithOptionalValue()
    {
        $this->ap->addLongOptions('bee::');

        $this->checkOptionAdded('bee', 'Option_Long', 'Argument_Optional');
    }

    public function testAddManyShortOptions()
    {
        $this->ap->addOptions('b:cd::');

        $this->checkOptionAdded('b', 'Option_Short', 'Argument_Mandatory');
        $this->checkOptionAdded('c', 'Option_Short', 'Argument_None');
        $this->checkOptionAdded('d', 'Option_Short', 'Argument_Optional');
    }

    public function testShortOptionAreParsed()
    {
        $this->ap->addOptions('a');

        $this->assertSame(array('a' => true), $this->ap->parse(array('-a')));
    }

    public function testMissingShortOptionAreNotParsed()
    {
        $this->ap->addOptions('a');

        $this->assertSame(array(), $this->ap->parse(array('-b')));
    }

    public function testLongOptionAreParsed()
    {
        $this->ap->addLongOptions('bee');

        $this->assertSame(array('bee' => true), $this->ap->parse(array('--bee')));
    }

    public function testMissingLongOptionAreNotParsed()
    {
        $this->ap->addLongOptions('bee');

        $this->assertSame(array(), $this->ap->parse(array('--cee')));
    }

    public function setUp()
    {
        $this->ap = new ArgumentParser();
    }

    public function tearDown()
    {
        unset($this->ap);
    }

    protected function checkOptionAdded($var, $optionType, $argumentType)
    {
        $this->assertTrue($this->ap->getOption($var) instanceof $optionType);
        $this->assertTrue($this->ap->getOption($var)->getArgument() instanceof $argumentType);
    }
}
