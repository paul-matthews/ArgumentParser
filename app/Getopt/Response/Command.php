<?php

class Getopt_Response_Command
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        $this->name;
    }

    public function toArray()
    {
        return array(
            'name' => $this->getName(),
        );
    }
}
