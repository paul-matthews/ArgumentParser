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

    public function testStaticCommandAttemptsParse()
    {
        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token('foo'),
            )
        ))->getResponse();

        $found = false;
        foreach ($response->toArray() as $command) {
            if ($command['name'] = self::DEFAULT_NAME) {
                $found = true;
            }
        }

        $this->assertTrue($found);
    }

    public function testShortOptionParsed()
    {
        $this->static->addOptions('a');

        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token('-a'),
            )
        ))->getResponse();

        $this->assertTrue($response->getCommand(self::DEFAULT_NAME)->getOption('a')->getValue());
    }

    public function testLongOptionParsed()
    {
        $name = 'foo';
        $this->static->addLongOptions($name);

        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token("--$name"),
            )
        ))->getResponse();

        $this->assertTrue($response->getCommand(self::DEFAULT_NAME)->getOption($name)->getValue());
    }

    public function testMultipleShortOptionsParsed()
    {
        $this->static->addOptions('abc');

        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token('-a'),
                new Getopt_Tokenizer_Token('-c'),
                new Getopt_Tokenizer_Token('-b'),
            )
        ))->getResponse();

        $this->assertTrue($response->getCommand(self::DEFAULT_NAME)->getOption('a')->getValue());
        $this->assertTrue($response->getCommand(self::DEFAULT_NAME)->getOption('b')->getValue());
        $this->assertTrue($response->getCommand(self::DEFAULT_NAME)->getOption('c')->getValue());
    }

    public function testShortOptionsWithMandatoryArgParsed()
    {
        $this->static->addOptions('a:');

        $value = 'testing';
        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token('-a'),
                new Getopt_Tokenizer_Token($value),
            )
        ))->getResponse();

        $this->assertSame($value, $response->getCommand(self::DEFAULT_NAME)->getOption('a')->getValue());
    }

    public function testShortOptionsWithOptionalArgParsed()
    {
        $this->static->addOptions('a::b::');

        $value = 'testing';
        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token('-a'),
                new Getopt_Tokenizer_Token($value),
                new Getopt_Tokenizer_Token('-b'),
            )
        ))->getResponse();

        $this->assertSame($value, $response->getCommand(self::DEFAULT_NAME)->getOption('a')->getValue());
        $this->assertTrue($response->getCommand(self::DEFAULT_NAME)->getOption('b')->getValue());
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
