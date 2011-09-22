<?php

class Getopt_Request_Tokenizer_PosixParamValueTest
    extends PHPUnit_Framework_TestCase
{
    public function testCreateShortRegex()
    {
        $this->assertEquals(
            '/^-([^-]{1})="?([^"]*)"?$/',
            Getopt_Request_Tokenizer_PosixParamValue::createShortRegex('-')
        );
    }

    public function testCreateLongRegex()
    {
        $this->assertEquals(
            '/^--([^-=]+)="?([^"]*)"?$/',
            Getopt_Request_Tokenizer_PosixParamValue::createLongRegex('-')
        );
    }

    public function testLongMatchesReturnCorrectToken()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParamValue(
            array(
                'Getopt_Request_Token_Param_Long'
                    => Getopt_Request_Tokenizer_PosixParamValue::createLongRegex('-')
            )
        );

        $tokens = $paramTokenizer->getTokens(array('--foo="bar"'));
        $firstToken = array_shift($tokens);
        $this->assertTrue($firstToken instanceof Getopt_Request_Token_Param_Long);
        $this->assertEquals('foo', $firstToken->getValue());
    }

    public function testLongWithValueMatchesReturnCorrectToken()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParamValue(
            array(
                'Getopt_Request_Token_Param_Long'
                    => Getopt_Request_Tokenizer_PosixParamValue::createLongRegex('-')
            )
        );

        $tokens = $paramTokenizer->getTokens(array('--foo="bar"'));
        $this->assertEquals(2, count($tokens));

        $firstToken = array_shift($tokens);
        $secondToken = array_shift($tokens);
        $this->assertTrue($firstToken instanceof Getopt_Request_Token_Param_Long);
        $this->assertEquals('foo', $firstToken->getValue());

        $this->assertTrue($secondToken instanceof Getopt_Request_Token_Value);
        $this->assertEquals('bar', $secondToken->getValue());
    }

    public function testLongMixedValueAndNoneReturnsCorrectTokens()
    {
        $paramTokenizer = new Getopt_Request_Tokenizer_PosixParam(
            array(
                'Getopt_Request_Token_Param_Long'
                    => Getopt_Request_Tokenizer_PosixParam::createLongRegex('-')
            )
        );
        $paramValueTokenizer = new Getopt_Request_Tokenizer_PosixParamValue(
            array(
                'Getopt_Request_Token_Param_Long'
                    => Getopt_Request_Tokenizer_PosixParamValue::createLongRegex('-')
            )
        );

        $paramValueTokenizer->addTokenizer($paramTokenizer);


        $tokens = $paramValueTokenizer->getTokens(array('--foo="bar"', '--moo'));
        $this->assertEquals(3, count($tokens));

        $firstToken = array_shift($tokens);
        $secondToken = array_shift($tokens);
        $thirdToken = array_shift($tokens);

        $this->assertTrue($firstToken instanceof Getopt_Request_Token_Param_Long);
        $this->assertEquals('foo', $firstToken->getValue());

        $this->assertTrue($secondToken instanceof Getopt_Request_Token_Value);
        $this->assertEquals('bar', $secondToken->getValue());

        $this->assertTrue($thirdToken instanceof Getopt_Request_Token_Param_Long);
        $this->assertEquals('moo', $thirdToken->getValue());
    }
}
