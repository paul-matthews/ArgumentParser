<?php

class Getopt_Item_Argument_None implements Getopt_Item_Argument_Interface
{
    public function parse(Getopt_Request_Interface $request)
    {
        return new Getopt_Response_Value(true);
    }

    public function isMatch(Getopt_Request_Interface $request)
    {
        return true;
    }
}
