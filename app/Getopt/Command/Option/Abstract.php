<?php

abstract class Getopt_Command_Option_Abstract
{
    protected $name;
    protected $rawName;
    protected $argument;
    protected $aliases;

    public function __construct($name, Getopt_Command_Argument_Interface $argument = null)
    {
        $this->rawName = $name;
        $this->name = ltrim(rtrim($this->rawName, ':'), '-');

        if (is_null($argument)) {
            $argument = new Getopt_Command_Argument_None();
        }
        $this->setArgument($argument);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRawName()
    {
        return $this->rawName;
    }

    public function setArgument(Getopt_Command_Argument_Interface $argument)
    {
        $this->argument = $argument;
    }

    public function parse(Getopt_Request_Interface $request)
    {
        if (!$this->isMatch($request)) {
            throw new Getopt_Command_Option_Exception('Option not set');
        }

        $response = new Getopt_Response_Option($this->getName());
        $response->setValue($this->getArgument()->parse($request));

        return $response;
    }

    public function getArgument()
    {
        return $this->argument;
    }

    public function addAlias(Getopt_Command_Option_Interface $alias)
    {
        $alias->setArgument($this->getArgument());

        $this->aliases[] = $alias;
    }

    public function getAlias($aliasName)
    {
        foreach ($this->aliases as $alias) {
            if ($alias->getName() == $aliasName) {
                return $alias;
            }
        }

        throw new OutOfBoundsException('Unkown Option Alias');
    }

    protected abstract function isMatch(Getopt_Request_Interface $request);
}
