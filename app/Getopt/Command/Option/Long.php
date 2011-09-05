<?php

class Getopt_Command_Option_Long
    extends Getopt_Command_Option_Abstract
    implements Getopt_Command_Option_Interface
{

    public function isMatch(Getopt_Request_Interface $request)
    {
        $indicator = $this->getConfig()->getOptionIndicator();
        $longIndicator = str_pad('', 2, $indicator);

        if ($request->current() == "{$longIndicator}{$this->getName()}") {
            return true;
        }
        return false;
    }
}
