<?php

class Getopt_Command_Argument_None implements Getopt_Command_Argument_Interface
{
    public function parse(Getopt_Request_Interface $request)
    {
        return new Getopt_Response_Value(true);
    }
}
