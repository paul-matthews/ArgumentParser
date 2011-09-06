<?php

class Getopt_Command_Option_Long
    extends Getopt_Command_Option_Abstract
    implements Getopt_Command_Option_Interface
{

    public function isMatch(Getopt_Request_Interface $request)
    {
        $longIndicator = $this->getConfig()->getLongOptionIndicator();;

        if ($request->current() == $longIndicator . $this->getName()) {
            return true;
        }
        return false;
    }
}
