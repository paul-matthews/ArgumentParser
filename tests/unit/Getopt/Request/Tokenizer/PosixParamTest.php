<?php

class Getopt_Request_Tokenizer_PosixParamTest
    extends PHPUnit_Framework_TestCase
{
    public function testCreateShortRegex()
    {
        $this->assertEquals(
            '/^-([^-]{1})$/',
            Getopt_Request_Tokenizer_PosixParam::createShortRegex('-')
        );
    }

    public function testCreateLongRegex()
    {
        $this->assertEquals(
            '/^--([^-]+)$/',
            Getopt_Request_Tokenizer_PosixParam::createLongRegex('-')
        );
    }

    public function testMatchesShortRegex()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParam(
            array(
                'Getopt_Request_Token_Param_Short'
                    => Getopt_Request_Tokenizer_PosixParam::createShortRegex('-')
            )
        );

        $this->assertTrue($paramTokenizer->canTokenize('-a'));
    }

    public function testNoMatchesIncorrectShortRegex()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParam(
            array(
                'Getopt_Request_Token_Param_Short'
                    => Getopt_Request_Tokenizer_PosixParam::createShortRegex('-')
            )
        );

        $this->assertFalse($paramTokenizer->canTokenize('--foo'));
    }

    public function testShortMatchesReturnCorrectToken()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParam(
            array(
                'Getopt_Request_Token_Param_Short'
                    => Getopt_Request_Tokenizer_PosixParam::createShortRegex('-')
            )
        );

        $tokens = $paramTokenizer->getTokens(array('-a'));
        $firstToken = array_pop($tokens);
        $this->assertTrue($firstToken instanceof Getopt_Request_Token_Param_Short);
        $this->assertEquals('a', $firstToken->getValue());
    }

    public function testLongMatchesReturnCorrectToken()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParam(
            array(
                'Getopt_Request_Token_Param_Long'
                    => Getopt_Request_Tokenizer_PosixParam::createLongRegex('-')
            )
        );

        $tokens = $paramTokenizer->getTokens(array('--foo'));
        $firstToken = array_pop($tokens);
        $this->assertTrue($firstToken instanceof Getopt_Request_Token_Param_Long);
        $this->assertEquals('foo', $firstToken->getValue());
    }
}
