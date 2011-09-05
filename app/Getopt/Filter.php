<?php

class Getopt_Filter
{
    public static function filter($value, $filterName)
    {
        $filterClass = "Getopt_Filter_$filterName";

        $filter = new $filterClass();

        return $filter->filter($value);
    }
}
