<?php

class Option_Abstract
{
    private $argument;
    private $name;

    public function __construct($name, Argument_Interface $argument)
    {
        $this->name = $name;
        $this->arugment = $argument;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getArgument()
    {
        return $this->arugment;
    }

    public function toArray()
    {
        return array( $this->getName() => $this->getArgument()->getValue());
    }

    public function __clone()
    {
        $this->arugment = clone $this->arugment;
    }
}