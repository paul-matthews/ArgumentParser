<?php

class Getopt_Response_Command
{
    private $name;
    private $options;

    public function __construct($name)
    {
        $this->name = $name;
        $this->options = array();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getOption($optionName)
    {
        foreach ($this->options as $option) {
            if ($option->getName() == $optionName) {
                return $option;
            }
        }

        throw new OutOfBoundsException('Option not set');
    }

    public function addOption(Getopt_Response_Option $option)
    {
        $this->options[] = $option;
    }

    public function toArray()
    {
        return array(
            'name' => $this->getName(),
        );
    }
}
