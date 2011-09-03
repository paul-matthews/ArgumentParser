<?php

abstract class Getopt_Command_Abstract
{
    private $name;
    protected $optionFactory;
    protected $options;

    public function __construct($name)
    {
        $this->name = $name;
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
        foreach ($this->getOptionFactory()->getOptions($options) as $option) {
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

    protected function getOptionFactory()
    {
        if (is_null($this->optionFactory)) {
            $this->optionFactory = new Getopt_Command_Option();
        }

        return $this->optionFactory;
    }
}
