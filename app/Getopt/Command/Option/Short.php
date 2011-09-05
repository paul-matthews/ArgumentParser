<?php

class Getopt_Command_Option_Short
    extends Getopt_Command_Option_Abstract
    implements Getopt_Command_Option_Interface
{

    public function isMatch(Getopt_Request_Interface $request)
    {
        $indicator = $this->getConfig()->getOptionIndicator();
        if ($request->current() == "{$indicator}{$this->getName()}") {
            return true;
        }
        return false;
    }
}
