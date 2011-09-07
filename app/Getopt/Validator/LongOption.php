<?php

class Getopt_Validator_LongOption
    extends Getopt_Validator_Abstract
    implements Getopt_Validator_Interface
{
    public function isValid($value)
    {
        $indicator = $this->getConfig()->getLongOptionIndicator();
        $indicatorLength = strlen($indicator);
        if (substr($value, 0, $indicatorLength) == $indicator) {
            return true;
        }
        return false;
    }
}
