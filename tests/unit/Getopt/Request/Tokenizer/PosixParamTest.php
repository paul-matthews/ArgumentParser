<?php

class Getopt_Request_Tokenizer_PosixParamTest
    extends PHPUnit_Framework_TestCase
{

    public function testMatchesSpecifier()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParam('-');

        $this->assertTrue($paramTokenizer->canTokenize('-a'));
    }

    public function testNoMatchesIncorrectSpecifiers()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParam('-');

        $this->assertFalse($paramTokenizer->canTokenize('=a'));
    }

    public function testNoMatchesIncorrectDoubleSpecifier()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParam('-');

        $this->assertFalse($paramTokenizer->canTokenize('--foo'));
    }

    public function testShortMatchesReturnCorrectToken()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParam('-');

        $tokens = $paramTokenizer->getTokens(array('-a'));
        $firstToken = array_shift($tokens);
        $this->assertTrue($firstToken instanceof Getopt_Request_Token_Param_Short);
        $this->assertEquals('a', $firstToken->getValue());
    }

    public function testLongMatchesReturnCorrectToken()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParam('--');

        $tokens = $paramTokenizer->getTokens(array('--foo'));
        $firstToken = array_shift($tokens);
        $this->assertTrue($firstToken instanceof Getopt_Request_Token_Param_Long);
        $this->assertEquals('foo', $firstToken->getValue());
    }
}
