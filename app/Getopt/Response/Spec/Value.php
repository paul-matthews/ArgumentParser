<?php

abstract class Getopt_Response_Spec_Value
{
    const RESPONSE_NO_MATCH = 0;
    const RESPONSE_MATCH = 1;
    const RESPONSE_UNKOWN = 2;

    public function filterArg(Getopt_Request_Token_Param $arg)
    {
        return $arg;
    }

    public function getRequest(Getopt_Request_Standard $request)
    {
        return new Getopt_Request_Sub($request, 0, 1);
    }

    public function parse(Getopt_Request_Standard $request)
    {
        if (!$this->match($request)) {
            throw new Getopt_Response_Spec_NoMatchException(
                $request, 'No match for ' . $this->__toString()
            );
        }

        return $this->doParse($request);
    }

    protected function match(Getopt_Request_Standard $arg)
    {
        return false;
    }

    protected function doParse(Getopt_Request_Standard $arg)
    {
        throw new OutOfBoundsException('Unimplemented');
    }
}
