<?php

class Getopt_Response_Spec_CommandTest
    extends PHPUnit_Framework_TestCase
{
    public function testParseReturnsEmptyItemItemsForMatch()
    {
        $request = new Getopt_Request_Standard(
            array(
                new Getopt_Request_Token_Value('cmd')
            )
        );

        $command = new Getopt_Response_Spec_Command('cmd');
        $this->assertEquals(array(), $command->parse($command->getRequest($request))->toArray());
    }

    public function testParseRetunsValidForTwoNestedCommands()
    {
        $request = new Getopt_Request_Standard(
            array(
                new Getopt_Request_Token_Value('cmd'),
                new Getopt_Request_Token_Value('cmd_no2')
            )
        );

        $command = new Getopt_Response_Spec_Command('cmd');
        $command->addChild(new Getopt_Response_Spec_Command('cmd_no2'));

        $this->assertEquals(array('cmd_no2' => array()), $command->parse($command->getRequest($request))->toArray());
    }

    public function testParseRetunsValidForTwoNestedTwoSiblingCommands()
    {
        $request = new Getopt_Request_Standard(
            array(
                new Getopt_Request_Token_Value('cmd'),
                new Getopt_Request_Token_Value('cmd_no2'),
                new Getopt_Request_Token_Value('cmd_no3'),
                new Getopt_Request_Token_Value('cmd_no4'),
            )
        );

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
            $command->parse(
                $command->getRequest($request)
            )->toArray()
        );
    }

    /**
     * testParseRetunsValidForInput
     *
     * @dataProvider tokenValues
     * @return void
     */
    public function testParseRetunsValidForInput($request, $command, $results)
    {
        $rawRequest = array();

        foreach ($request as $req) {
            $rawRequest[] = new Getopt_Request_Token_Value($req);
        }
        $preparedRequest = new Getopt_Request_Standard($rawRequest);

        $this->assertEquals(
            $results,
            $command->parse(
                $command->getRequest($preparedRequest)
            )->toArray()
        );
    }

    public function tokenValues()
    {
        $command = new Getopt_Response_Spec_Command('cmd');
        $command2 = new Getopt_Response_Spec_Command('cmd_no2');
        $command3 = new Getopt_Response_Spec_Command('cmd_no3');
        $command4 = new Getopt_Response_Spec_Command('cmd_no4');
        $command5 = new Getopt_Response_Spec_Command('cmd_no5');
        $command6 = new Getopt_Response_Spec_Command('cmd_no6');
        $command7 = new Getopt_Response_Spec_Command('cmd_no7');
        $command8 = new Getopt_Response_Spec_Command('cmd_no8');

        $command->addChild($command2);
        $command->addChild($command3);

        $command3->addChild($command4);
        $command3->addChild($command5);
        $command3->addChild($command6);

        $command6->addChild($command7);
        $command6->addChild($command8);

        $request = array('cmd', 'cmd_no2', 'cmd_no3', 'cmd_no4');

        return array(
            array(
                array('cmd',),
                $command,
                array(
                ),
            ),
            array(
                array('cmd', 'cmd_no2', 'cmd_no3', 'cmd_no4'),
                $command,
                array(
                    'cmd_no2' => array(),
                    'cmd_no3' => array(
                        'cmd_no4' => array(),
                    )
                ),
            ),
            array(
                array('cmd', 'cmd_no2', 'cmd_no3', 'cmd_no4', 'cmd_no5'),
                $command,
                array(
                    'cmd_no2' => array(),
                    'cmd_no3' => array(
                        'cmd_no4' => array(),
                        'cmd_no5' => array(),
                    )
                ),
            ),
            array(
                array('cmd', 'cmd_no2', 'cmd_no3', 'cmd_no4', 'cmd_no6'),
                $command,
                array(
                    'cmd_no2' => array(),
                    'cmd_no3' => array(
                        'cmd_no4' => array(),
                        'cmd_no6' => array(),
                    )
                ),
            ),
            array(
                array('cmd', 'cmd_no2', 'cmd_no3', 'cmd_no4', 'cmd_no6', 'cmd_no8'),
                $command,
                array(
                    'cmd_no2' => array(),
                    'cmd_no3' => array(
                        'cmd_no4' => array(),
                        'cmd_no6' => array(
                            'cmd_no8' => array(),
                        ),
                    )
                ),
            ),
        );
    }
}
