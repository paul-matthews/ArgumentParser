<?php

class Getopt_Command_Option_Short
    extends Getopt_Command_Option_Abstract
    implements Getopt_Command_Option_Interface
{

    public function isMatch(Getopt_Request_Interface $request)
    {
        if ($request->current() == "-{$this->getName()}") {
            return true;
        }
        return false;
    }
}
