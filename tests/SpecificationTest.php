<?php

class SpecifciationTest extends PHPUnit_Framework_TestCase
{
    public function testTokenizerReturnsShortOptions()
    {
        $result = $this->go->getRequest(array('-a'));
        $first = $result->current();

        $this->assertTrue($first instanceof Getopt_Token_Short);
        $this->assertSame('a', $first->getValue());
    }

    public function testTokenizerReturnsLongOptions()
    {
        $result = $this->go->getRequest(array('--test'));
        $first = $result->current();

        $this->assertTrue($first instanceof Getopt_Token_Long);
        $this->assertSame('test', $first->getValue());
    }

    public function testTokenizerReturnsValues()
    {
        $result = $this->go->getRequest(array('test'));
        $first = $result->current();

        $this->assertTrue($first instanceof Getopt_Token_Value);
        $this->assertSame('test', $first->getValue());
    }

    public function testTokenizerReturnsOptionaAndValue()
    {
        $result = $this->go->getRequest(array('--foo="test"'));
        $first = $result->current();
        $second = $result->next();

        $this->assertTrue($first instanceof Getopt_Token_Long);
        $this->assertSame('foo', $first->getValue());
        $this->assertTrue($second instanceof Getopt_Token_Value);
        $this->assertSame('test', $second->getValue());
    }

    public function setUp()
    {
        $this->go = new Getopt();
    }
}
