<?php

abstract class Getopt_Command_Option_Abstract
{
    protected $name;

    public function __construct($name)
    {
        $this->name = rtrim($name, ':');
    }

    public function getName()
    {
        return $this->name;
    }
}
