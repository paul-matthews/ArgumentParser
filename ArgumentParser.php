<?php

class ArgumentParser
{
    private $options;
    private $optionFactory;

    public function __construct()
    {
        $this->options = array();
    }

    public function parse($params)
    {
        $command = new Command($params);

        foreach ($command as $arg) {
            foreach ($this->options as $option) {
                $command = $option->parse($arg, $command);
            }
        }

        return $command->getResults();
    }

    public function addOption(Option_Interface $option)
    {
        $this->options[] = $option;
        return $this;
    }

    public function addLongOptions($options)
    {
        if (!is_array($options)) {
            $options = array($options);
        }

        $factory = $this->getOptionFactory();
        foreach ($factory->getLongOptions($options) as $option) {
            $this->addOption($option);
        }

        return $this;
    }


    public function addOptions($options)
    {
        $factory = $this->getOptionFactory();

        foreach ($factory->getShortOptions($factory->getSeparateOptions($options)) as $option) {
            $this->addOption($option);
        }
        return $this;
    }

    public function getOption($name)
    {
        foreach ($this->options as $option) {
            if ($option->getName() == $name) {
                return $option;
            }
        }

        throw new Exception('Unknown Option');
    }

    public function getOptions()
    {
        return $this->options;
    }

    protected function getOptionFactory()
    {
        if (is_null($this->optionFactory)) {
            $this->optionFactory = new Option();
        }

        return $this->optionFactory;
    }
}
