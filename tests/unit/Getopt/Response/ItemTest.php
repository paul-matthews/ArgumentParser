<?php

class Getopt_Response_ItemTest extends PHPUnit_Framework_TestCase
{
    public function testManyResponsesReturnArray()
    {
        $items = new Getopt_Response_Item_Items();
        $subItems = new Getopt_Response_Item_Items();

        $subItems->addValue(new Getopt_Response_Item('sea'), 'c');

        $items->addValue(new Getopt_Response_Item('test'), 'a');
        $items->addValue($subItems, 'b');

        $this->assertEquals(
            array(
                'a' => 'test',
                'b' => array(
                    'c' => 'sea',
                ),
            ),
            $items->toArray()
        );
    }

    public function testMultipleSameKeysReturnArrayOfValues()
    {
        $items = new Getopt_Response_Item_Items();

        $items->addValue(new Getopt_Response_Item('test'), 'a');
        $items->addValue(new Getopt_Response_Item('aye'), 'a');

        $this->assertEquals(
            array(
                'a' => array(
                    'test',
                    'aye'
                ),
            ),
            $items->toArray()
        );
    }
}
