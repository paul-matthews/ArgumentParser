<?php

class Getopt_Validator_Option
    extends Getopt_Validator_Abstract
{
    public function isValid($value)
    {
        if (
            Getopt_Validator::isValid($value, 'LongOption')
            || Getopt_Validator::isValid($value, 'ShortOption')
        ) {
            return true;
        }
        return false;
    }
}
