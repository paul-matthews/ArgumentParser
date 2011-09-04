<?php

class Getopt_Command_Option_Long
    extends Getopt_Command_Option_Abstract
    implements Getopt_Command_Option_Interface
{

    protected function isMatch(Getopt_Request_Interface $request)
    {
        if ($request->current() == "--{$this->getName()}") {
            return true;
        }
        return false;
    }
}
