<?php

class Getopt_Response_Spec_CommandTest
    extends PHPUnit_Framework_TestCase
{
    public function testIsMatchReturnsTrueForValid()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Value('cmd')
        ));

        $command = new Getopt_Response_Spec_Command('cmd');
        $this->assertTrue($command->isMatch($request));
    }

    public function testIsMatchReturnsFalseForInvalid()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Value('cmd_no2')
        ));

        $command = new Getopt_Response_Spec_Command('cmd');
        $this->assertFalse($command->isMatch($request));
    }

    public function testParseReturnsEmptyItemItemsForMatch()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Value('cmd')
        ));

        $command = new Getopt_Response_Spec_Command('cmd');
        $this->assertEquals(array(), $command->parse($request)->toArray());
    }

    public function testParseRetunsValidForTwoNestedCommands()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Value('cmd'),
            new Getopt_Request_Token_Value('cmd_no2')
        ));

        $command = new Getopt_Response_Spec_Command('cmd');
        $command->addChild(new Getopt_Response_Spec_Command('cmd_no2'));
        $this->assertEquals(
            array('cmd_no2' => array()),
            $command->parse($request)->toArray()
        );
    }

    public function testParseRetunsValidForTwoNestedTwoSiblingCommands()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Value('cmd'),
            new Getopt_Request_Token_Value('cmd_no2'),
            new Getopt_Request_Token_Value('cmd_no3'),
            new Getopt_Request_Token_Value('cmd_no4'),
        ));

        $command3 = new Getopt_Response_Spec_Command('cmd_no3');
        $command3->addChild(new Getopt_Response_Spec_Command('cmd_no4'));

        $command = new Getopt_Response_Spec_Command('cmd');
        $command->addChild(new Getopt_Response_Spec_Command('cmd_no2'));
        $command->addChild($command3);

        $this->assertEquals(
            array(
                'cmd_no2' => array(),
                'cmd_no3' => array(
                    'cmd_no4' => array(),
                )
            ),
            $command->parse($request)->toArray()
        );
    }
}
