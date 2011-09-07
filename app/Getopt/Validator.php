<?php

class Getopt_Validator
{
    public static function isValid($value, $validateName)
    {
        $validateClass = "Getopt_Validator_$validateName";

        $validate = new $validateClass();

        return $validate->isValid($value);
    }
}
