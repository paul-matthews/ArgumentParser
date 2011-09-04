<?php

class Getopt_Command_Argument_Mandatory implements Getopt_Command_Argument_Interface
{
    public function parse(Getopt_Request_Interface $request)
    {
        if (!$this->isValue($request->peek())) {
            throw new Getopt_Command_Option_Exception('Value not set');
        }
        return new Getopt_Response_Value((string) $request->next());
    }

    protected function isValue($item)
    {
        if (substr($item, 0, 1) != '-') {
            return true;
        }
        return false;
    }
}
