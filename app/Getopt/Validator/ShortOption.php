<?php

class Getopt_Validator_ShortOption
    extends Getopt_Validator_Abstract
    implements Getopt_Validator_Interface
{
    public function isValid($value)
    {
        $indicator = $this->getConfig()->getShortOptionIndicator();
        $indicatorLength = strlen($indicator);
        if (substr($value, 0, $indicatorLength) == $indicator) {
            return true;
        }
        return false;
    }
}
