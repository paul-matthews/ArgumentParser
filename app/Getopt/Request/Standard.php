<?php

class Getopt_Request_Standard
    implements Iterator, Countable
{
    protected $args;

    public function __construct(array $args)
    {
        $this->args = $args;
    }

    public function getArgs()
    {
        return $this->args;
    }

    public function rewind()
    {
        return reset($this->args);
    }

    public function current()
    {
        return current($this->args);
    }

    public function key()
    {
        return key($this->args);
    }

    public function next()
    {
        return next($this->args);
    }

    public function valid()
    {
        return $this->current() !== false;
    }

    public function prev()
    {
        return prev($this->args);
    }

    public function count()
    {
        return count($this->args);
    }

    public function getAsArray()
    {
        return $this->args;
    }
}
