<?php

class Getopt_Request_Token_Value
{
    private $value;
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
