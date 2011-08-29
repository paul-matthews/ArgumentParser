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

        $this->assertTrue($this->ap->getOption('b') instanceof Option_Short);
        $this->assertTrue($this->ap->getOption('b')->getArgument() instanceof Argument_None);
    }

    public function testAddOptionsWithMandatoryValue()
    {
        $this->ap->addOptions('b:');

        $this->assertTrue($this->ap->getOption('b') instanceof Option_Short);
        $this->assertTrue($this->ap->getOption('b')->getArgument() instanceof Argument_Mandatory);
    }

    public function testAddOptionsWithOptionalValue()
    {
        $this->ap->addOptions('b::');

        $this->assertTrue($this->ap->getOption('b') instanceof Option_Short);
        $this->assertTrue($this->ap->getOption('b')->getArgument() instanceof Argument_Optional);
    }

    public function testAddLongOptionsWithNoValue()
    {
        $this->ap->addLongOptions('bee');

        $this->assertTrue($this->ap->getOption('bee') instanceof Option_Long);
        $this->assertTrue($this->ap->getOption('bee')->getArgument() instanceof Argument_None);
    }

    public function testAddLongOptionsWithMandatoryValue()
    {
        $this->ap->addLongOptions('bee:');

        $this->assertTrue($this->ap->getOption('bee') instanceof Option_Long);
        $this->assertTrue($this->ap->getOption('bee')->getArgument() instanceof Argument_Mandatory);
    }

    public function testAddLongOptionsWithOptionalValue()
    {
        $this->ap->addLongOptions('bee::');

        $this->assertTrue($this->ap->getOption('bee') instanceof Option_Long);
        $this->assertTrue($this->ap->getOption('bee')->getArgument() instanceof Argument_Optional);
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
