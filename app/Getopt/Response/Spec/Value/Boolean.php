<?php

class Getopt_Response_Spec_Value_Boolean
    extends Getopt_Response_Spec_Value
    implements Getopt_Response_Spec
{
    const NO_FORMAT1 = 'no%s';
    const NO_FORMAT2 = 'no-%s';

    const TOSTRING_FORMAT = '[Value_Boolean: bool]';

    public function filterArg(Getopt_Request_Token_Param $arg)
    {
        if ($match = $this->getArgMatch($arg)) {
            return new Getopt_Request_Token_Param($match);
        }

        return $arg;
    }

    public function getRequest(Getopt_Request_Standard $request)
    {
        $potential = new Getopt_Request_Sub($request, 0, 2, false);

        if (count($potential) != 2) {
            return new Getopt_Request_Sub($request, 0, 1, false);
        }

        $second = $potential->next();
        if (!($second instanceof Getopt_Request_Token_Value)) {
            return new Getopt_Request_Sub($request, 0, 1, false);
        }
        $potential->rewind();

        return $potential;
    }

    protected function doParse(Getopt_Request_Standard $request)
    {
        if ($this->getArgMatch($request->current())) {
            return new Getopt_Response_Item(false);
        }

        $next = $request->next();
        if ($next instanceof Getopt_Request_Token_Value && !$next->getValue()) {
            return new Getopt_Response_Item(false);
        }

        return new Getopt_Response_Item(true);
    }

    protected function match(Getopt_Request_Standard $request)
    {
        return true;
    }

    public function __toString()
    {
        return self::TOSTRING_FORMAT;
    }

    protected function getArgMatch($arg)
    {
        foreach (array('/^no-(.*)/', '/^no([^-]+.*)/') as $pattern) {
            preg_match($pattern, $arg->getValue(), $matches);

            if (isset($matches[1])) {
                return $matches[1];
            }
        }

        return false;
    }
}
