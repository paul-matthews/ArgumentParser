<?php

class Argument
{
    public function getArgument($option)
    {
        if (substr($option, -2) == '::') {
            return new Argument_Optional();
        }

        if (substr($option, -1) == ':') {
            return new Argument_Mandatory();
        }

        return new Argument_None();
    }
}
