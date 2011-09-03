<?php

class Getopt_Command_Option
{
    public function getOptions($rawOptions)
    {
        $options = array();
        foreach ($this->getSeparateOptions($rawOptions) as $option) {
            $options[] = new Getopt_Command_Option_Short($option);
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
