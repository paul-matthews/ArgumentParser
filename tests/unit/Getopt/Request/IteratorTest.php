<?php

class Getopt_Request_IteratorTest
    extends PHPUnit_Framework_TestCase
{
    private $request;
    public function setUp()
    {
        $this->request = new Getopt_Request_Standard(range(0, 10));
    }

    public function testKeyNullReturnsWholeArray()
    {
        $output = array();

        foreach (new Getopt_Request_Iterator($this->request) as $value) {
            $output[] = $value;
        }

        $this->assertEquals(range(0, 10), $output);
    }

    public function testKeySetReturnsPartArray()
    {
        $output = array();

        foreach (new Getopt_Request_Iterator($this->request, 5) as $value) {
            $output[] = $value;
        }

        $this->assertEquals(range(5, 10), $output);
    }

    public function testKeySetZeroReturnsWholeArray()
    {
        $output = array();

        foreach (new Getopt_Request_Iterator($this->request, 0) as $value) {
            $output[] = $value;
        }

        $this->assertEquals(range(0, 10), $output);
    }

    public function testKeyIntegrityRetained()
    {
        $output = array();

        foreach (new Getopt_Request_Iterator($this->request, 5) as $key => $value) {
            $output[] = $key;
        }

        $this->assertEquals(range(5, 10), $output);
    }
}
