<?php

class Getopt_Filter_ValueName
    extends Getopt_Filter_Abstract
    implements Getopt_Filter_Interface
{
    public function filter($value)
    {
        $shortIndicator = $this->getConfig()->getShortOptionIndicator();
        $longIndicator = $this->getConfig()->getShortOptionIndicator();
        $specifier = $this->getConfig()->getArgumentSpecifier();

        return ltrim(ltrim(rtrim($value, $specifier), $shortIndicator), $longIndicator);
    }
}
