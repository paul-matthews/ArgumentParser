<?php

class CommandTest extends PHPUnit_Framework_TestCase
{
    const DEFAULT_NAME = 'test';

    public function testSetCommandName()
    {
        $this->assertSame(self::DEFAULT_NAME, $this->static->getName());
    }

    public function testSetShortOption()
    {
        $this->static->addOption(new Getopt_Command_Option_Short('a', new Getopt_Command_Argument_None()));

        $this->assertTrue($this->static->getOption('a') instanceof Getopt_Command_Option_Short);
    }

    public function testSetShortOptionString()
    {
        $this->static->addOptions('a');

        $this->assertTrue($this->static->getOption('a') instanceof Getopt_Command_Option_Short);
    }

    public function testSetMandatoryShortOptionString()
    {
        $this->static->addOptions('a:');

        $this->assertTrue($this->static->getOption('a')->getArgument() instanceof Getopt_Command_Argument_Mandatory);
    }

    public function testSetOptionalShortOptionString()
    {
        $this->static->addOptions('a::');

        $this->assertTrue($this->static->getOption('a')->getArgument() instanceof Getopt_Command_Argument_Optional);
    }

    public function testSetLongOption()
    {
        $this->static->addOption(new Getopt_Command_Option_Long('--test'));

        $this->assertTrue($this->static->getOption('test') instanceof Getopt_Command_Option_Long);
    }

    public function testSetLongOptionString()
    {
        $this->static->addLongOptions('test');

        $this->assertTrue($this->static->getOption('test') instanceof Getopt_Command_Option_Long);
    }

    public function testSetLongOptionStringOptionalArguments()
    {
        $this->static->addLongOptions('test::');

        $this->assertTrue($this->static->getOption('test')->getArgument() instanceof Getopt_Command_Argument_Optional);
    }

    public function testSetLongOptionStringMandatoryArguments()
    {
        $this->static->addLongOptions('test:');

        $this->assertTrue($this->static->getOption('test')->getArgument() instanceof Getopt_Command_Argument_Mandatory);
    }

    public function testSetAliasOnShortOption()
    {
        $this->static->addOptions('a:');

        $option = $this->static->getOption('a');
        $alias = new Getopt_Command_Option_Short('b');

        $option->addAlias($alias);

        $this->assertSame($alias, $option->getAlias($alias->getName()));
    }

    public function testSetAliasInheritsArguments()
    {
        $this->static->addOptions('a:');

        $alias = new Getopt_Command_Option_Short('b', new Getopt_Command_Argument_None());
        $this->static->getOption('a')->addAlias($alias);

        $this->assertSame(
            $this->static->getOption('a')->getArgument(),
            $this->static->getOption('a')->getAlias($alias->getName())->getArgument()
        );
    }

    public function testSetLongAliasOnShortOption()
    {
        $this->static->addOptions('a:');

        $alias = new Getopt_Command_Option_Long('test');
        $this->static->getOption('a')->addAlias($alias);

        $this->assertSame(
            $alias,
            $this->static->getOption('a')->getAlias($alias->getName())
        );
    }

    public function setUp()
    {
        $this->static = new Getopt_Command_Static(self::DEFAULT_NAME);
    }
}
