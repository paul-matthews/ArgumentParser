<?php

class Getopt_Command_Argument_Optional implements Getopt_Command_Argument_Interface
{
    public function parse(Getopt_Request_Interface $request)
    {
        if (!$this->isValue($request->peek())) {
            return true;
        }

        return (string) $request->next();
    }

    protected function isValue($item)
    {
        if ($item && substr($item, 0, 1) != '-') {
            return true;
        }
        return false;
    }
}
