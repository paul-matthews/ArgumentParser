<?php

class Getopt_Command_Option
{
    public function getShortOptions($rawOptions)
    {
        $options = array();
        foreach ($this->getSeparateOptions($rawOptions) as $option) {
            $options[] = new Getopt_Command_Option_Short($option, new Getopt_Command_Argument_None());
        }
        return $options;
    }

    public function getLongOptions($rawOptions)
    {
        $options = array();
        foreach ($rawOptions as $option) {
            $options[] = new Getopt_Command_Option_Long($option, new Getopt_Command_Argument_None());
        }
        return $options;
    }

    public function getSeparateOptions($options)
    {
        preg_match_all('/\w:{0,2}/', $options, $matches);

        if ($matches[0]) {
            return $matches[0];
        }

        return array();
    }
}
