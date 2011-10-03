<?php

class Getopt_Response_Spec_ArgumentTest
    extends PHPUnit_Framework_TestCase
{
    public function testIsMatchReturnsTrueForValid()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Param('a')
        ));
        $mockValue = $this->getMock('Getopt_Response_Spec_Value_Null', array('isMatch', 'parse', 'hasArgMatch'));

        $mockValue->expects($this->atLeastOnce())
            ->method('isMatch')
            ->will($this->returnValue(true));

        $mockValue->expects($this->never())
            ->method('parse')
            ->will($this->returnValue(new Getopt_Response_Item(true)));

        $mockValue->expects($this->atLeastOnce())
            ->method('hasArgMatch')
            ->will($this->returnValue(Getopt_Response_Spec_Value::RESPONSE_UNKOWN));

        $argument = new Getopt_Response_Spec_Argument('a', $mockValue);
        $this->assertTrue($argument->isMatch($request));
    }

    public function testIsMatchReturnsFalseForInvalid()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Param('b')
        ));
        $mockValue = $this->getMock('Getopt_Response_Spec_Value_Null', array('isMatch', 'parse', 'hasArgMatch'));

        $mockValue->expects($this->never())
            ->method('isMatch')
            ->will($this->returnValue(true));

        $mockValue->expects($this->never())
            ->method('parse')
            ->will($this->returnValue(new Getopt_Response_Item(true)));

        $mockValue->expects($this->atLeastOnce())
            ->method('hasArgMatch')
            ->will($this->returnValue(Getopt_Response_Spec_Value::RESPONSE_UNKOWN));

        $argument = new Getopt_Response_Spec_Argument('a', $mockValue);
        $this->assertFalse($argument->isMatch($request));
    }

    public function testParseReturnsResultForValid()
    {
        $request = new Getopt_Request_Standard(array(
            new Getopt_Request_Token_Param('a')
        ));
        $mockValue = $this->getMock('Getopt_Response_Spec_Value_Null', array('isMatch', 'parse', 'hasArgMatch'));

        $mockValue->expects($this->atLeastOnce())
            ->method('isMatch')
            ->will($this->returnValue(true));

        $mockValue->expects($this->atLeastOnce())
            ->method('parse')
            ->will($this->returnValue(new Getopt_Response_Item(true)));

        $mockValue->expects($this->atLeastOnce())
            ->method('hasArgMatch')
            ->will($this->returnValue(Getopt_Response_Spec_Value::RESPONSE_UNKOWN));

        $argument = new Getopt_Response_Spec_Argument('a', $mockValue);

        $this->assertTrue($argument->parse($request)->getValue());
    }
}
