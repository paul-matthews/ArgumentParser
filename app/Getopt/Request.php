<?php

class Getopt_Request
{
    public function getRequest($input)
    {
        if (!is_array($input)) {
            throw new InvalidArgumentException('Unknown request input type');
        }

        return new Getopt_Request_Array($input);
    }
}
