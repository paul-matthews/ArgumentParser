<?php

class Getopt_Request_Filter_SplitMultiple
    extends Getopt_Request_Filter
{
    private $match;
    private $split;

    public function __construct($match, $split, $splitFormat = '%s')
    {
        parent::__construct();

        $this->match = $match;
        $this->split = $split;
        $this->splitFormat = $splitFormat;
    }

    public function doFilter(array $args)
    {
        $args = $this->filter($args);
        return parent::doFilter($args);
    }

    private function filter(array $args)
    {
        $filtered = array();

        foreach ($args as $arg) {
            $filtered = array_merge($filtered, $this->doSplit($arg));
        }

        return $filtered;
    }

    private function doSplit($arg)
    {
        if (preg_match($this->match, $arg) !== 0) {
            $matches = array();
            preg_match_all($this->split, $arg, $matches);

            if (count($matches) > 0) {
                $prepedMatches = array();
                foreach ($matches[0] as $match) {
                    $prepedMatches[] = sprintf($this->splitFormat, $match);
                }
                return $prepedMatches;
            }
        }
        return array($arg);
    }
}
