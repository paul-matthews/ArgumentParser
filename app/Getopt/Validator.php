<?php

class Getopt_Validator
{
    public static function isValid($value, $name, $options = array())
    {
        return self::getValidator($name, $options)->isValid($value);
    }

    public static function getValidator($name, $options = array())
    {
        $validateClass = "Getopt_Validator_$name";

        return new $validateClass($options);
    }
}
