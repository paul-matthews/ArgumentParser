<?php

class Getopt_Response_Spec_Value_Null
    extends Getopt_Response_Spec_Value
    implements Getopt_Response_Spec
{
    const TOSTRING_FORMAT = '[Value_Null: null]';
    public function parse(Getopt_Request_Standard $request, $key = null)
    {
        return new Getopt_Response_Item(true);
    }

    public function isMatch(Getopt_Request_Standard $request, $key = null)
    {
        return true;
    }

    public function __toString()
    {
        return self::TOSTRING_FORMAT;
    }
}
