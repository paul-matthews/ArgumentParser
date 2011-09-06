<?php

class Getopt_Command_Option
{
    public function getShortOptions($rawOptions)
    {
        $options = array();
        $shortOptions = Getopt_Filter::filter($rawOptions, 'SeparateShortOptsSpec');
        foreach ($shortOptions as $option) {
            $options[] = new Getopt_Command_Option_Short(
                $option,
                new Getopt_Command_Argument_None()
            );
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
}
