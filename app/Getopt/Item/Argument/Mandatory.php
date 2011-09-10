<?php

class Getopt_Item_Argument_Mandatory
    extends Getopt_Item_Argument_Abstract
    implements Getopt_Item_Argument_Interface
{
    public function parse(Getopt_Request_Interface $request)
    {
        if (!$this->isValue($request->peek())) {
            throw new Getopt_Item_Option_Exception('Value not set');
        }
        return new Getopt_Response_Value((string) $request->next());
    }

    public function isMatch(Getopt_Request_Interface $request)
    {
        if (!$this->isValue($request->peek())) {
            return false;
        }
        return true;
    }
}
