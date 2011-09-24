<?php

class Getopt_RequestTest extends PHPUnit_Framework_TestCase
{
    public function testWithSingleInputReturnsRequest()
    {
        $requestFactory = new Getopt_Request(
            new Getopt_Request_Filter_SplitMultiple('/^-\w{2,}/', '/\w{1}/', '-%s'),
            new Getopt_Request_Tokenizer_PosixParam('-')
        );

        $request = $requestFactory->getRequest(array('-a'));
        $this->assertEquals(1, count($request));
    }

    public function testInputReturnsRequestContainingCorrectTypes()
    {
        $requestFactory = new Getopt_Request(
            new Getopt_Request_Filter_SplitMultiple('/^-\w{2,}/', '/\w{1}/', '-%s'),
            new Getopt_Request_Tokenizer_PosixParam('-')
        );

        $request = $requestFactory->getRequest(array('-a', '-b', '-c'));

        $this->assertEquals(3, count($request));
        foreach ($request as $key => $arg) {
            $this->assertTrue($arg instanceof Getopt_Request_Token_Param_Short);
        }
    }

    public function testDifferntTypeInputReturnsRequestContainingCorrectTypes()
    {
        $tokenizer = new Getopt_Request_Tokenizer_PosixParam('--');
        $tokenizer->addTokenizer(new Getopt_Request_Tokenizer_PosixParam('-'));

        $requestFactory = new Getopt_Request(
            new Getopt_Request_Filter_SplitMultiple('/^-\w{2,}/', '/\w{1}/', '-%s'),
            $tokenizer
        );

        $request = $requestFactory->getRequest(array('-a', '--bee', '-c'));

        $this->assertEquals(3, count($request));
        foreach ($request as $key => $arg) {
            if ($arg->getValue() == 'bee') {
                $this->assertTrue($arg instanceof Getopt_Request_Token_Param_Long);
            }
            else {
                $this->assertTrue($arg instanceof Getopt_Request_Token_Param_Short);
            }
        }
    }
}
