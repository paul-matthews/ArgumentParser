<?php

class CommandTest extends PHPUnit_Framework_TestCase
{
    const DEFAULT_NAME = 'test';

    public function testSetCommandName()
    {
        $this->assertSame(self::DEFAULT_NAME, $this->static->getName());
    }

    public function testStaticCommandAttemptsParse()
    {
        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token('foo'),
            )
        ));

        $found = false;
        $this->assertTrue(in_array(self::DEFAULT_NAME, array_keys($response->getValue())));
    }

    public function testShortOptionParsed()
    {
        $this->static->addOptions('a');

        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token('-a'),
            )
        ))->getValue();

        $this->assertTrue($response[self::DEFAULT_NAME]['a']);
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
        ))->getValue();

        $this->assertTrue($response[self::DEFAULT_NAME][$name]);
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
        ))->getValue();

        $this->assertTrue($response[self::DEFAULT_NAME]['a']);
        $this->assertTrue($response[self::DEFAULT_NAME]['b']);
        $this->assertTrue($response[self::DEFAULT_NAME]['c']);
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
        ))->getValue();

        $this->assertSame($value, $response[self::DEFAULT_NAME]['a']);
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
        ))->getValue();

        $this->assertSame($value, $response[self::DEFAULT_NAME]['a']);
        $this->assertTrue($response[self::DEFAULT_NAME]['b']);
    }

    public function testAliasOptionParsed()
    {
        $this->static->addOptions('a');
        $this->static->getOption('a')->addAlias($this->getLongOption('test'));

        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token('--test'),
            )
        ))->getValue();

        $this->assertTrue($response[self::DEFAULT_NAME]['a']);
    }

    public function testSetMandatoryShortOptionString()
    {
        $this->static->addOptions('a:');

        $this->assertTrue($this->static->getOption('a')->getArgument() instanceof Getopt_Item_Argument_Mandatory);
    }

    public function testSetOptionalShortOptionString()
    {
        $this->static->addOptions('a::');

        $this->assertTrue($this->static->getOption('a')->getArgument() instanceof Getopt_Item_Argument_Optional);
    }

    public function testSetLongOptionStringOptionalArguments()
    {
        $this->static->addLongOptions('test::');

        $this->assertTrue($this->static->getOption('test')->getArgument() instanceof Getopt_Item_Argument_Optional);
    }

    public function testSetLongOptionStringMandatoryArguments()
    {
        $this->static->addLongOptions('test:');

        $this->assertTrue($this->static->getOption('test')->getArgument() instanceof Getopt_Item_Argument_Mandatory);
    }

    public function testSetAliasOnShortOption()
    {
        $this->static->addOptions('a:');

        $option = $this->static->getOption('a');
        $alias = $this->getShortOption('b');

        $option->addAlias($alias);

        $this->assertSame($alias, $option->getAlias($alias->getName()));
    }

    public function testSetAliasInheritsArguments()
    {
        $this->static->addOptions('a:');

        $alias = $this->getShortOption('b');
        $this->static->getOption('a')->addAlias($alias);

        $this->assertSame(
            $this->static->getOption('a')->getArgument(),
            $this->static->getOption('a')->getAlias($alias->getName())->getArgument()
        );
    }

    public function testSetLongAliasOnShortOption()
    {
        $this->static->addOptions('a:');

        $alias = $this->getLongOption('test');
        $this->static->getOption('a')->addAlias($alias);

        $this->assertSame(
            $alias,
            $this->static->getOption('a')->getAlias($alias->getName())
        );
    }

    public function testShortOptionIndicatorCanBeSlash()
    {
        $config = Getopt_Config::getInstance();
        $config->setShortOptionIndicator('/');
        Getopt_Config::setInstance($config);

        $this->static->addOptions('a');

        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token('/a'),
            )
        ))->getValue();

        $this->assertTrue($response[self::DEFAULT_NAME]['a']);
    }

    public function testLongOptionIndicatorCanOnlyBeHyphen()
    {
        $config = Getopt_Config::getInstance();
        $config->setShortOptionIndicator('/');
        Getopt_Config::setInstance($config);

        $this->static->addLongOptions(array('test1', 'test2'));

        $response = $this->static->parse(new Getopt_Request_Array(
            array(
                new Getopt_Tokenizer_Token(self::DEFAULT_NAME),
                new Getopt_Tokenizer_Token('--test1'),
                new Getopt_Tokenizer_Token('///test2'),
            )
        ))->getValue();

        $this->assertTrue($response[self::DEFAULT_NAME]['test1']);
        $this->assertTrue(!isset($response[self::DEFAULT_NAME]['test2']));
    }

    public function setUp()
    {
        $this->static = new Getopt_Item_Command_Static(self::DEFAULT_NAME);
        $this->optionFactory = new Getopt_Item_Option();
    }
    public function tearDown()
    {
        Getopt_Config::resetInstance();
    }

    private function getShortOption($name)
    {
        $options = $this->optionFactory->getShortOptions($name);
        return $options[0];
    }

    private function getLongOption($name)
    {
        $options = $this->optionFactory->getLongOptions(array($name));
        return $options[0];
    }
}
