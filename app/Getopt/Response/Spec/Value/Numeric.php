<?php

class Getopt_Response_Spec_Value_Numeric
    extends Getopt_Response_Spec_Value
    implements Getopt_Response_Spec
{
    const TOSTRING_FORMAT = '[Value_Numeric: string]';

    protected function doParse(Getopt_Request_Token $arg)
    {
        return new Getopt_Response_Item($arg->getValue());
    }

    protected function match(Getopt_Request_Token $arg)
    {
        if ($arg instanceof Getopt_Request_Token_Value) {
            return is_numeric($arg->getValue);
        }
        return false;
    }

    public function __toString()
    {
        return self::TOSTRING_FORMAT;
    }
}
