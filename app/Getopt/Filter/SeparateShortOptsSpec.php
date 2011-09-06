<?php

class Getopt_Filter_SeparateShortOptsSpec
    extends Getopt_Filter_Abstract
    implements Getopt_Filter_Interface
{
    public function filter($value)
    {
        $specifier = $this->getConfig()->getArgumentSpecifier();
        preg_match_all(
            sprintf('/\w(%s){0,2}/', $specifier),
            $value,
            $matches
        );

        if ($matches[0]) {
            return $matches[0];
        }

        return array();
    }
}

