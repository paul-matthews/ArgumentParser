<?php

class Getopt_Filter_SeparateShortOpts
    extends Getopt_Filter_Abstract
    implements Getopt_Filter_Interface
{
    public function filter($value)
    {
        $config = $this->getConfig();
        $indicator = $config->getOptionIndicator();
        $separators = $config->getOptionValueSeparator();

        preg_match_all(
            sprintf(
                "/^%s([^%s]{%d,})/",
                $indicator,
                implode(array_merge(array($indicator), $separators)),
                strlen($indicator)
            ),
            $value,
            $matches
        );

        $value = array($value);
        if (count($matches[1]) && count($matches[1][0]) > 0) {
            $value = array();
            foreach (str_split($matches[1][0]) as $match) {
                $value[] = $indicator . $match;
            }
        }

        return $value;
    }
}

