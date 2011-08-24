<?php

class ArgumentAlias
{
    private $from;
    private $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function matches($key)
    {
        if ($this->from == $key) {
            return true;
        }

        return false;
    }

    public function convert($key)
    {
        if ($this->from == $key) {
            return $this->to;
        }

        return $key;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }
}
