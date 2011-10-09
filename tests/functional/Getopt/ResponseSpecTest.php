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

        $command = new Getopt_Response_Spec_Command('cmd');
        $command->addChild(new Getopt_Response_Spec_Argument(
            'a', new Getopt_Response_Spec_Value_Null()
        ));

        $response = $command->parse(
            $command->getRequest($request)
        );

        $this->assertEquals(
            array(
                'a' => true,
            ),
            $response->toArray()
        );
    }

    public function testCommandWithArgMatchReturnsValue()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Value('cmd'),
            new Getopt_Request_Token_Param('no-foo'),
        ));

        $command = new Getopt_Response_Spec_Command('cmd');
        $command->addChild(new Getopt_Response_Spec_Argument(
            'foo', new Getopt_Response_Spec_Value_Boolean()
        ));

        $response = $command->parse(
            $command->getRequest($request)
        );

        $this->assertEquals(
            array(
                'foo' => false,
            ),
            $response->toArray()
        );
    }

    /*
    public function testCommandWithNumericArgMatchReturnsValue()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Value('cmd'),
            new Getopt_Request_Token_Param('foo'),
            new Getopt_Request_Token_Param('10'),
        ));

        $command = new Getopt_Response_Spec_Command('cmd');
        $command->addChild(new Getopt_Response_Spec_Argument(
            'foo', new Getopt_Response_Spec_Value_Numeric()
        ));

        $response = $command->parse($request);
        $this->assertEquals(
            array(
                'foo' => 10,
            ),
            $response->toArray()
        );
    }
     */
}
