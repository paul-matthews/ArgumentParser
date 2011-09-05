<?php

class Getopt_Filter_ValueName
    extends Getopt_Filter_Abstract
    implements Getopt_Filter_Interface
{
    public function filter($value)
    {
        $indicator = $this->getConfig()->getOptionIndicator();
        $specifier = $this->getConfig()->getArgumentSpecifier();

        return ltrim(rtrim($value, $specifier), $indicator);
    }
}
