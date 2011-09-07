<?php

class Getopt_Filter_ValueName
    extends Getopt_Filter_Abstract
    implements Getopt_Filter_Interface
{
    public function filter($value)
    {
        $longIndicator = $this->getConfig()->getShortOptionIndicator();
        $specifier = $this->getConfig()->getArgumentSpecifier();

        if (Getopt_Validator::isValid($value, 'LongOption')) {
            $indicator = $this->getConfig()->getLongOptionIndicator();
            $value = substr($value, strlen($indicator));
        }

        if (Getopt_Validator::isValid($value, 'ShortOption')) {
            $indicator = $this->getConfig()->getShortOptionIndicator();
            $value = substr($value, strlen($indicator));
        }

        return rtrim($value, $specifier);
    }
}
