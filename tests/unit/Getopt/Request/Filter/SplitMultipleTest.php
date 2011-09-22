<?php

class Getopt_Request_Filter_SplitMultipleTest
    extends PHPUnit_Framework_TestCase
{

    public function testSplitsMultipleShortOptions()
    {
        $filter = new Getopt_Request_Filter();
        $filter->addFilter(
            new Getopt_Request_Filter_SplitMultiple('/^-\w{2,}/', '/\w{1}/', '-%s')
        );

        $this->assertEquals(array('-a', '-b', '-c'), $filter->doFilter(array('-abc')));
    }
}
