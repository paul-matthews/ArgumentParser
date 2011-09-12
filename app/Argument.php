<?php

class Argument
{
    const LONG_OPTION = '--';
    const SHORT_OPTION = '-';

    private $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function getName()
    {
        return ltrim($this->input, self::SHORT_OPTION);
    }

    public function isLong()
    {
        return (boolean) (substr($this->input, 0, 2) == self::LONG_OPTION);
    }

    public function isShort()
    {
        return (boolean) (
            substr($this->input, 0, 1) == self::SHORT_OPTION
            && !$this->isLong()
        );
    }
}
