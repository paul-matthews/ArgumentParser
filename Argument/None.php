<?php

class Argument_None implements Argument_Interface
{
    public function parse($arg, $cmd)
    {
        return true;
    }

    public function getValue()
    {
        return true;
    }
}
