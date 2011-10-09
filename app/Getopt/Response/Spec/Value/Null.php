<?php

class Getopt_Response_Spec_Value_Null
    extends Getopt_Response_Spec_Value
    implements Getopt_Response_Spec
{
    const TOSTRING_FORMAT = '[Value_Null: null]';
    protected function doParse(Getopt_Request_Standard $arg)
    {
        return new Getopt_Response_Item(true);
    }

    public function match(Getopt_Request_Standard $request)
    {
        return true;
    }

    public function __toString()
    {
        return self::TOSTRING_FORMAT;
    }
}
