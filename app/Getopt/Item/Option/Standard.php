<?php

class Getopt_Item_Option_Standard
    implements Getopt_Item_Option_Interface
{
    protected $name;
    protected $rawName;
    protected $argument;
    protected $validator;
    protected $aliases;

    public function __construct(
        $name, Getopt_Validator_Interface $validator,
        Getopt_Item_Argument_Interface $argument = null
    ) {
        $this->validator = $validator;
        $this->filter = Getopt_Filter::getFilter('ValueName');

        $this->rawName = $name;
        $this->name = $this->filter->filter($this->rawName);

        if (is_null($argument)) {
            $argument = new Getopt_Item_Argument_None();
        }

        $this->setArgument($argument);
        $this->aliases = array();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRawName()
    {
        return $this->rawName;
    }

    public function setArgument(Getopt_Item_Argument_Interface $argument)
    {
        $this->argument = $argument;
    }

    public function isMatch(Getopt_Request_Interface $request)
    {
        $item = $request->current();
        if ($this->validator->isValid($item)
            && $this->filter->filter($item) == $this->getName()
            && $this->getArgument()->isMatch($request)
        ) {
            return true;
        }
        return false;
    }

    public function parse(Getopt_Request_Interface $request)
    {
        if (!$this->isMatch($request) && !$this->isAliasMatch($request)) {
            throw new Getopt_Item_Option_Exception('Option not set');
        }

        $response = new Getopt_Response_Container($this->getName());
        $finalResponse = $response->addValue($this->getArgument()->parse($request));;
        return $finalResponse;
    }

    public function getArgument()
    {
        return $this->argument;
    }

    public function addAlias(Getopt_Item_Option_Interface $alias)
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

    public function addChild(Getopt_Item $child)
    {
        throw new Exception('Unimplemented');
    }

    protected function isAliasMatch($request)
    {
        foreach ($this->aliases as $alias) {
            if ($alias->isMatch($request)) {
                return true;
            }
        }
        return false;
    }
}

