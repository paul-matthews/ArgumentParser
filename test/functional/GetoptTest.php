<?php

class GetoptTest extends PHPUnit_Framework_TestCase
{
    public function testCreateRequestTokens()
    {
        $rawInput = array(
            '-a', '-b', '-c',
        );

        $request = $this->go->getRequest($rawInput);

        $tokens = array();
        foreach ($request->getTokens() as $token) {
            $tokens[] = (string) $token;
        }

        $this->assertSame($rawInput, $tokens);
    }

    public function testCreateRequestTokensCombined()
    {
        $rawInput = array(
            '-a', '-bcd', '-e',
        );

        $getopt = new Getopt();

        $request = $this->go->getRequest($rawInput);

        $tokens = array();
        foreach ($request->getTokens() as $token) {
            $tokens[] = (string) $token;
        }

        $this->assertSame(
            array(
                '-a', '-b', '-c',
                '-d', '-e',
            ),
            $tokens
        );
    }

    public function setUp()
    {
        $this->go = new Getopt();
    }

    public function tearDown()
    {
        unset($this->go);
    }
}
