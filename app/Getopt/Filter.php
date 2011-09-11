<?php

class Getopt_Filter
{
    public static function filter($value, $filterName, $options = array())
    {
        return self::getFilter($filterName, $options)->filter($value);
    }

    public static function getFilter($filter, $options = array())
    {
        $filterClass = "Getopt_Filter_$filter";

        return new $filterClass($options);
    }
}
