<?php

class Getopt_Command_Option_Short
    extends Getopt_Command_Option_Abstract
    implements Getopt_Command_Option_Interface
{

    public function isMatch(Getopt_Request_Interface $request)
    {
        $item = $request->current();
        if (Getopt_Validator::isValid($item, 'ShortOption')
            && Getopt_Filter::filter($item, 'ValueName') == $this->getName()
        ) {
            return true;
        }
        return false;
    }
}
