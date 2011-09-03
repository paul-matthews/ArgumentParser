<?php

class Getopt_Command_Argument
{
    const OPTIONAL = '::';
    const MANDATORY = ':';

    public function getArgument($rawOption)
    {
        if (substr($rawOption, -2) == self::OPTIONAL) {
            return new Getopt_Command_Argument_Optional();
        }

        if (substr($rawOption, -1) == self::MANDATORY) {
            return new Getopt_Command_Argument_Mandatory();
        }

        return new Getopt_Command_Argument_None();
    }
}
