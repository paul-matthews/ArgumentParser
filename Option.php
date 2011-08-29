<?php

class Option
{
    private $argumentFactory;

    public function getShortOptions($options)
    {
        if (!is_array($options)) {
            throw new InvalidArgumentException('Invalid Options: Expected Array');
        }

        $shortOptions = array();
        foreach ($options as $option) {
            if (strlen($option) > 3) {
                throw new InvalidArgumentException('Incorrect Short Option: No more than 3 chars');
            }

            $shortOptions[] = new Option_Short(
                rtrim($option, ':'),
                $this->getArgumentFactory()->getArgument($option)
            );
        }

        return $shortOptions;
    }

    public function getLongOptions($options)
    {
        if (!is_array($options)) {
            throw new InvalidArgumentException('Invalid Options: Expected Array');
        }

        $longOptions = array();

        foreach ($options as $option) {
            $longOptions[] = new Option_Long(
                rtrim($option, ':'),
                $this->getArgumentFactory()->getArgument($option)
            );
        }

        return $longOptions;
    }

    public function getSeparateOptions($options)
    {
        preg_match_all('/\w:{0,2}/', $options, $matches);

        if (count($matches) < 1) {
            throw new Exception('No options found');
        }

        return $matches[0];
    }

    public function getArgumentFactory()
    {
        if (is_null($this->argumentFactory)) {
            $this->argumentFactory = new Argument();
        }

        return $this->argumentFactory;
    }
}
