<?php
require_once __DIR__ . '/Argument.php';
require_once __DIR__ . '/Option.php';

class ArgumentParser
{
    private $shortOptions;
    private $longOptions;

    public function addOption($option)
    {
        $this->shortOptions[] = new Option($option);
    }

    public function addLongOption($option)
    {
        $this->longOptions[] = new Option($option);
    }

    public function parse($input)
    {
        if (!is_array($input)) {
            $input = array($input);
        }

        $response = array();
        foreach ($input as $item) {
            $argument = new Argument($item);

            if ($argument->isShort()
                && $value = $this->compare($argument->getName(), $this->shortOptions)
            ) {
                $response[$argument->getName()] = $value;
                continue;
            }

            if ($argument->isLong()
                && $value = $this->compare($argument->getName(), $this->longOptions)
            ) {
                $response[$argument->getName()] = $value;
                continue;
            }
        }

        return $response;
    }

    protected function compare($item, $options)
    {
        foreach ($options as $option) {
            if ($value = $option->getValue($item)) {
                return $value;
            }
        }
        return false;
    }
}
