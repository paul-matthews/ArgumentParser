<?php

class Getopt_Request
    implements Iterator
{
    private $tokens;

    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    public function peek()
    {
        $return = $this->next();
        prev($this->tokens);
        return $return;
    }

    public function rewind()
    {
        return reset($this->tokens);
    }

    public function next()
    {
        return next($this->tokens);
    }

    public function current()
    {
        return current($this->tokens);
    }

    public function key()
    {
        return key($this->tokens);
    }

    public function valid()
    {
        if ($this->current() !== false) {
            return true;
        }
        return false;
    }
}
