<?php

class Getopt_Request_Filter
{
    private $filters;
    public function __construct()
    {
        $this->filters = array();
    }

    public function doFilter(array $args)
    {
        foreach ($this->filters as $filter) {
            $args = $filter->doFilter($args);
        }
        return $args;
    }

    public function addFilter(Getopt_Request_Filter $filter)
    {
        $this->filters[] = $filter;
    }
}
