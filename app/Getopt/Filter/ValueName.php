<?php

class Getopt_Filter_ValueName
    extends Getopt_Filter_Abstract
    implements Getopt_Filter_Interface
{
    public function filter($value)
    {
        $config = $this->getConfig();

        return ltrim(
            ltrim(
                rtrim(
                    $value,
                    $config->getArgumentSpecifier()
                ),
                $config->getShortOptionIndicator()
            ),
            $config->getLongOptionIndicator()
        );
    }
}
