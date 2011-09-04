<?php

abstract class Getopt_Command_Abstract
{
    private $name;
    protected $optionFactory;
    protected $argumentFactory;
    protected $options;

    public function __construct($name)
    {
        $this->name = $name;
        $this->options = array();
    }

    public function getName()
    {
        return $this->name;
    }


    public function addOption(Getopt_Command_Option_Interface $option)
    {
        $this->options[] = $option;
        return $this;
    }

    public function addOptions($options)
    {
        foreach ($this->getOptionFactory()->getShortOptions($options) as $option) {
            $option->setArgument(
                $this->getArgumentFactory()->getArgument($option->getRawName())
            );
            $this->addOption($option);
        }
        return $this;
    }

    public function addLongOptions($options)
    {
        if (!is_array($options)) {
            $options = array($options);
        }

        foreach ($this->getOptionFactory()->getLongOptions($options) as $option) {
            $option->setArgument(
                $this->getArgumentFactory()->getArgument($option->getRawName())
            );
            $this->addOption($option);
        }
        return $this;
    }

    public function getOption($optionName)
    {
        foreach ($this->options as $option) {
            if ($option->getName() == $optionName) {
                return $option;
            }
        }

        throw new OutOfBoundsException('Unknown Option');
    }

    public function getOptions()
    {
        return $this->options;
    }

    protected function getOptionFactory()
    {
        if (is_null($this->optionFactory)) {
            $this->optionFactory = new Getopt_Command_Option();
        }

        return $this->optionFactory;
    }

    protected function getArgumentFactory()
    {
        if (is_null($this->argumentFactory)) {
            $this->argumentFactory = new Getopt_Command_Argument();
        }

        return $this->argumentFactory;
    }
}
