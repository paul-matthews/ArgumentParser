<?php

class Getopt_Request
{
    public function __construct(
        Getopt_Filter $filter = null,
        Getopt_Mutator $mutator = null
    ) {
        // $this->filters =;
    }

    public function getRequest($input)
    {
        if (!is_array($input)) {
            throw new InvalidArgumentException('Unknown request input type');
        }

        return new Getopt_Request_Array($input);
    }
}
