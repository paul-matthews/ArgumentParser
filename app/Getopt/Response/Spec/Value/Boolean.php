<?php

class Getopt_Response_Spec_Value_Boolean
    extends Getopt_Response_Spec_Value
    implements Getopt_Response_Spec
{
    const NO_FORMAT1 = 'no%s';
    const NO_FORMAT2 = 'no-%s';

    const TOSTRING_FORMAT = '[Value_Boolean: bool]';
    protected function doParse(Getopt_Request_Token $arg)
    {
        if (preg_match('/^no/', $arg->getValue())) {
            return new Getopt_Response_Item(false);
        }

        return new Getopt_Response_Item(true);
    }

    public function isMatch(Getopt_Request_Standard $request, $key = null)
    {
        return true;
    }

    public function hasArgMatch(Getopt_Response_Spec_Argument $arg, Getopt_Request_Token $token)
    {
        if (in_array($token->getValue(), array_keys($this->getValues($arg->getName())))) {
            return self::RESPONSE_MATCH;
        }
        return self::RESPONSE_UNKOWN;
    }

    public function __toString()
    {
        return self::TOSTRING_FORMAT;
    }

    protected function getValues($name)
    {
        return array(
            $name => true,
            sprintf(self::NO_FORMAT1, $name) => false,
            sprintf(self::NO_FORMAT2, $name) => false,
        );
    }
}
