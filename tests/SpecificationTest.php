<?php

class SpecifciationTest extends PHPUnit_Framework_TestCase
{
    public function testTokenizerReturnsShortOptions()
    {
        $go = new Getopt();
        $result = $go->tokenize(array('-a'));
        $first = array_pop($result);

        $this->assertTrue($first instanceof Getopt_Token_Short);
        $this->assertSame('a', $first->getValue());
    }

    public function testTokenizerReturnsLongOptions()
    {
        $go = new Getopt();
        $result = $go->tokenize(array('--test'));
        $first = array_pop($result);

        $this->assertTrue($first instanceof Getopt_Token_Long);
        $this->assertSame('test', $first->getValue());
    }

    public function testTokenizerReturnsValues()
    {
        $go = new Getopt();
        $result = $go->tokenize(array('test'));
        $first = array_pop($result);

        $this->assertTrue($first instanceof Getopt_Token_Value);
        $this->assertSame('test', $first->getValue());
    }

    public function setUp()
    {
        $this->go = new Getopt();
    }
}
