<?php

class Getopt_ResposeSpecTest
    extends PHPUnit_Framework_TestCase
{
    public function testCommandReturnsValue()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Value('cmd'),
            new Getopt_Request_Token_Param('a'),
        ));
        $mockValue = $this->getMock('Getopt_Response_Spec_Value_Null', array('isMatch', 'parse'));

        $command = new Getopt_Response_Spec_Command('cmd');
        $command->addChild(new Getopt_Response_Spec_Argument(
            'a', new Getopt_Response_Spec_Value_Null()
        ));

        $response = $command->parse($request);
        $this->assertEquals(
            array(
                'a' => true,
            ),
            $response->toArray()
        );
    }
}
