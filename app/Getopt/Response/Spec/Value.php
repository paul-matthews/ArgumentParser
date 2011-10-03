<?php

abstract class Getopt_Response_Spec_Value
{
    const RESPONSE_NO_MATCH = 0;
    const RESPONSE_MATCH = 1;
    const RESPONSE_UNKOWN = 2;

    public function parse(Getopt_Request_Standard $request, $key = null)
    {
        foreach (new Getopt_Request_Iterator($request, $key) as $value) {
            return $this->doParse($value);
        }
    }

    public function isMatch(Getopt_Request_Standard $request, $key = null)
    {
        foreach (new Getopt_Request_Iterator($request, $key) as $arg) {
            return $this->match($arg);
        }
    }

    public function hasArgMatch(Getopt_Response_Spec_Argument $arg, Getopt_Request_Token $token)
    {
        return self::RESPONSE_UNKOWN;
    }

    protected function doParse(Getopt_Request_Token $arg)
    {
        throw new OutOfBoundsException('Unimplemented');
    }

    protected function match(Getopt_Request_Token $arg)
    {
        return false;
    }
}
